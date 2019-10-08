<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;

/*
 *　質問に応じて目的を取得する処理
 * 
*/
class placesController extends Controller
{
    public function getObjectiveList(){	
        $objective = new Objective();
        $items = $objective->getAll();
        return $items;
    }

    public function getPlaceKeyList($id){
        $placekeyword = new Placekeyword();
        $items = $placekeyword->findByAreaId($id);
        return $items;
    }


}
