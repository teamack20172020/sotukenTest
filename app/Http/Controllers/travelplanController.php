<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;
use App\Models\Placelist;
use App\Http\Service\googleApiService;

//　旅行プランに関する操作
class travelplanController extends Controller
{
    /**
	 * 目的: 旅行プランの生成
	 * @param String $spoint_name 出発地名
	 * @param String $spoint 出発地座標
	 * @param String $main_objectiveId メイン目的ID
     * @param String $sub_objectiveId サブ目的ID
	 * @param String $areaId 地域ID
	 *
	 **/
    public function getTravelPlan($spoint_name,$spoint,$main_objectiveId,$sub_objectiveId,$areaId) :array
    {
        $maxTime = 0;
        $objective = new Objective();
        $placelist = new Placelist();
        $main_obj = $objective->getById($main_objectiveId);
        $sub_obj = $objective->getById($sub_objectiveId);
        $main_place = $placelist->findByAreaIdAndObjectId($main_objectiveId,$areaId);
        $sub_place = $placelist->findByAreaIdAndObjectId($sub_objectiveId,$areaId);

        $from = $spoint;
        $count = 0;
        $insData = array();

        for($i=0;$i<9;$i++){
            while(true){
                // @TODO 最大滞在時間を超過した場合を後で考慮する必要がある
                //メイン目的が最大回数､もしくはメイン目的の行き先がない場合
                //かつサブ目的の行き先がない場合､もしくはメイン目的とサブ目的が同じ
                //もしくは最大滞在時間がマイナスの場合
                if((($main_obj[0]->maxcount <= $count || count($main_place)==0)
                    && (count($sub_place)==0 || $main_objectiveId==$sub_objectiveId))
                    || $maxTime < 0){
                    break;
                }

                if($i%2==0 && $main_obj[0]->maxcount > $count && count($main_place)!=0){
                    $count++;
                    $obj = $main_obj;
                    $list = &$main_place;
                }else{
                    if($main_objectiveId!=$sub_objectiveId){
                        $obj = $sub_obj;
                        $list = &$sub_place;
                    }
                }

                //行先を決定する
                $tolist = $this->getPlace($list);
                //行き先の情報をセット
                $to = $tolist->address;
                $pushData=array(
                    'name'=>$tolist->name,
                    'address'=>$to,
                    'number'=>$tolist->phone_number,
                    'site-url'=>$tolist->site_url,
                );

                //旅程を一行セットする
                array_push($pushData,$this->setRow($from,$to,$maxTime));
                //経路が正しく取得できているかのチェック
                if(!(empty($pushData[0]))){
                    //目的毎に設定された目的地での滞在時間を減少させる
                    $maxTime -= intval($obj[0]->maxsecond);
                    if($maxTime == 0){
                        $maxTime = -1;
                    }
                    array_push($insData,$pushData);
                    //目的地(to)を出発地(from)に入れる
                    $from = $to;
                    break;
                }
            }
        }
        //帰りの経路の算出
        $to = $spoint;
        $pushData = array(
            'name'=>$spoint_name,
            'address'=>$to,
        );
        array_push($pushData,$this->setRow($from,$to,$maxTime));
        array_push($insData,$pushData);
        return $insData;
    }

    /**
	 * 目的: 目的地をランダムに取得
	 * @param array $list 目的地リスト
	 *
	 **/
    public function getPlace(&$list) :object
    {
        $max = count($list)-1;
        $rnd = mt_rand(0,$max);
        $res = $list[$rnd];
        unset($list[$rnd]);
        $list = array_values($list);
        return $res;
    }

    /**
	 * 目的: 経路を取得し、プランを退避する
	 * @param String $from 出発地住所
     * @param String $to　目的地住所
     * @param int $maxTime 最大滞在時間
	 *
	 **/
    public function setRow($from,$to,&$maxTime) :array
    {
        $googleApi = new googleApiService();
        $res = $googleApi->getDirectionList($from,$to);
        if(empty($res)){
            $row = Array();
        }else{
            //最大滞在時間が設定されていれば､移動時間を減少させる
            //設定されていなければ最大滞在時間を設定
            if($maxTime != 0){
                $maxTime -= intval($res[0]->legs[0]->duration->value);
            }else{
                $maxTime = 7 * 60 * 60;
            }
            //目的地の位置情報をセット
            $row = array(
                'lat'=>$res[0]->legs[0]->end_location->lat,
                'lng'=>$res[0]->legs[0]->end_location->lng,
                'time_ja'=>$res[0]->legs[0]->duration->text,
                //'time_second'=>$res[0]->legs[0]->duration->value,
            );
        }
        return $row;
    }
}
