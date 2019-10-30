<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placelist;
use App\Http\Service\googleApiService;

//　旅行プランに関する操作
class travelplanController extends Controller
{
    /**
	 * 目的: 旅行プランの生成
	 * @param String $spoint_name 出発地名
	 * @param String $spoint 出発地座標
	 * @param String $objectId 目的ID
	 * @param String $areaId 地域ID
	 *
	 **/
    public function getTravelPlan($spoint_name,$spoint,$objectId,$areaId) :array
    {
        $maxTime = 7 * 60 * 60;
        $placelist = new Placelist();
        $list = $placelist->findByAreaIdAndObjectId($objectId,$areaId);
        

        $from = $spoint;
        $from_name = $spoint_name;

        $insData = array();      
        for($i=0;$i<3;$i++){
            while(true){
                if(count($list)==0){
                    break;
                }
                
                //行先を決定する
                $tolist = $this->getPlace($list);
                $to = $tolist->address;
                $to_name = $tolist->name;
                
                //旅程を一行セットする
                $pushData = $this->setRow($from,$from_name,$to,$to_name);
                if(!(is_Null($pushData) || count($pushData)==0)){
                    array_push($insData,$pushData);
                    //toをfromに入れる
                    $from = $to;
                    $from_name = $to_name;
                    break;
                }
            }
        }

        //帰りの経路の算出
        $to = $spoint;
        $to_name = $spoint_name;
        array_push($insData,$this->setRow($from,$from_name,$to,$to_name));
        return $insData;
    }

    /**
	 * 目的: 目的地をランダムに取得
	 * @param array $list 目的地リスト
	 *
	 **/
    public function getPlace(&$list) :array
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
     * @param String $from_name　出発地名
     * @param String $to　目的地住所
     * @param String $to_name　目的地名
	 *
	 **/
    public function setRow($from,$from_name,$to,$to_name) :array
    {
        $googleApi = new googleApiService();
        $res = $googleApi->getDirectionList($from,$to);
        if(is_Null($res) || count($res)==0){
            $row = Array();
        }else{
            $spoint = [
                'address'=>$res[0]->legs[0]->start_address,
                'name'=>$from_name,
                'lat'=>$res[0]->legs[0]->start_location->lat,
                'lng'=>$res[0]->legs[0]->start_location->lng,
            ];

            $epoint = [
                'address' => $res[0]->legs[0]->end_address,
                'name' => $to_name,
                'lat' =>$res[0]->legs[0]->end_location->lat,
                'lng' =>$res[0]->legs[0]->end_location->lng,
            ];

            $row = array(
                'startPoint'=>$spoint,
                'endPoint'=>$epoint,
                'time_ja'=>$res[0]->legs[0]->duration->text,
                'time_second'=>$res[0]->legs[0]->duration->value,
            );
        }   
        return $row;
    }
}
