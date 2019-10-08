<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placekeyword extends Model
{
    //
    public function findById($id){	
        $items = \DB::table($this->table)->where('id',$id)->get();
        return $items;
    }

    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }
}
