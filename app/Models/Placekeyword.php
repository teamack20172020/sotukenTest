<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placekeyword extends Model
{
    protected $table = 'placekeyword';
    //県コード別に取得
    public function findByAreaId($areaId){	
        $items = \DB::table($this->table)->where('area_id',$areaId)->where('objective_id',1)->get();
        return $items;
    }

    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }
}
