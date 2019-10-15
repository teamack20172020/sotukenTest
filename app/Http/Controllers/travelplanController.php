<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placelist;

/*
 *　旅行プランに関する操作
 * 
*/
class travelplanController extends Controller
{
    public function createTravelPlan($objectId,$areaId){
        $placelist = new Placelist();
        $list = $placelist->findByAreaIdAndObjectId($objectId,$areaId);

        return $list;
    }

    public function saveTravelPlan(){

    }

}
