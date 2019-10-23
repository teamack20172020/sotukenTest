<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Placelist extends Model
{
    protected $table = 'placelist';
    //県コード・目的別に取得
    public function findByAreaIdAndObjectId($objectId,$areaId) :array
    {
        $items = \DB::table($this->table)->where('objective_id',$objectId)->where('area_id',$areaId)->get()->toArray();
        return $items;
    }

    public function saveList($dataList) :void
    {
        \DB::table($this->table)->insert($dataList);
    }

    public function deleteByAreaId($areaId) :void
    {
        \DB::table($this->table)->where('area_id',$areaId)->delete();
    }
}
