<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;
use App\Models\Placekeyword;
use App\Models\Placelist;
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
    public function savePlaceList($areaId,$objectiveId){
        $placelist = new Placelist();
        $placekeyword = new Placekeyword();

        //対象都道府県の目的地リストの削除
        $placelist->deleteByAreaId($areaId);

        //目的地候補リストの取得用キーワードを検索
        $items = $placekeyword->findByAreaId($areaId);
        //キーワードごとに処理
        for($i=0;$i<count($items);$i++){
            //googleapiで目的地候補リストの取得
            $googleApi = new googleApiService();
            $res = $googleApi->getPlaceList('香川県',$items[$i]->keyword);
            $insData = array();
            //目的地候補ごとに処理
            for($j=0;$j<count($res);$j++){
                array_push($insData ,
                    ["name"=>$res[$j]->name ,
                    "object_id"=>$items[$i]->objective_id,
                    "address"=>$res[$j]->formatted_address]);
            }
            //データベースに目的地候補リストを登録
            $placelist->savelist($insData);
        }
        return $insData;
    }

}
