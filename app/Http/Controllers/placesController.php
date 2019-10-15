<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;
use App\Models\Placekeyword;
use App\Models\Placelist;
use App\Models\Master;
use App\Http\Service\googleApiService;

/*
 *　目的と目的地に関する操作
 *
*/
class placesController extends Controller
{
    public function getObjectiveList(){
        $objective = new Objective();
        $items = $objective->getAll();
        return $items;
    }

    //id 県コード
    public function savePlaceList($areaId){
        $placelist = new Placelist();
        $placekeyword = new Placekeyword();
        $master = new Master();
        $kbn = 1;
        //対象都道府県の目的地リストの削除
        $placelist->deleteByAreaId($areaId);

        //目的地候補リストの取得用キーワードを検索
        $items = $placekeyword->findByAreaId($areaId);
        //県コードから県名を取得
        $area = $master->findByKbnAndSubId($kbn,$areaId)[0]->sub_name;
        //キーワードごとに処理
        for($i=0;$i<count($items);$i++){
            //googleapiで目的地候補リストの取得
            $googleApi = new googleApiService();
            $res = $googleApi->getPlaceList($area,$items[$i]->keyword);
            $insData = array();
            //目的地候補ごとに処理
            for($j=0;$j<count($res);$j++){
                array_push($insData ,
                    ["name"=>$res[$j]->name ,
                    "objective_id"=>$items[$i]->objective_id,
                    "address"=>$res[$j]->formatted_address,
                    "area_id"=>$areaId]);
            }
            //データベースに目的地候補リストを登録
            $placelist->savelist($insData);
        }
        return $insData;
    }

}
