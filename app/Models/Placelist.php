<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placelist extends Model
{
    protected $table = 'placelist';
    
    //県コード・目的別に取得
    public function findByAreaIdAndObjectId($objectiveId,$areaId){	
        $items = \DB::table($this->table)->where('objective_id',$objectiveId)->where('area_id',$areaId)->get();
        return $items;
    }

    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }

    public function deleteByAreaId($areaId)
    {
        \DB::table($this->table)->where('area_id',$areaId)->delete();
    }
}
