<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 目的地リストテーブルへの操作
class Placelist extends Model
{
    protected $table = 'placelist';

    /**
     * 目的: 目的地リストを県コード・目的別に取得
     * 引数: objectId　目的ID
     * 　　　areaId　地域ID
     **/
    public function findByAreaIdAndObjectId($objectId,$areaId) :array
    {
        $items = \DB::table($this->table)->where('objective_id',$objectId)->where('area_id',$areaId)->get()->toArray();
        return $items;
    }

    /**
     * 目的: 目的地リストを保存
     * 引数: dataList　目的地リスト
     **/
    public function saveList($dataList) :void
    {
        \DB::table($this->table)->insert($dataList);
    }

    /**
     * 目的: 目的地リストを地域ID別に削除
     * 引数: areaId　地域ID
     **/
    public function deleteByAreaId($areaId) :void
    {
        \DB::table($this->table)->where('area_id',$areaId)->delete();
    }
}
