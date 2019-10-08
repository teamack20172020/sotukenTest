<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placekeyword extends Model
{
    //県コード別に取得
    public function findByAreaId($areaid){	
        $items = \DB::table($this->table)->where('id',$areaid)->get();
        return $items;
    }

    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }
}
