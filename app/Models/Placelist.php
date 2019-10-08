<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Placelist extends Model
{
    //県コード・目的別に取得
    public function findByAreaIdAndObjectId($areaid){	
        $items = \DB::table($this->table)->where('id',$areaid)->get();
        return $items;
    }

    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }
}
