<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 目的地リストテーブルへの操作
class Placelist extends Model
{
    // テーブル名
    protected $table = 'placelist';

    /**
     * 目的: 目的地リストを県コード・主目的別に取得
     * @param int $mainObjectId　主目的ID
     * @param int $areaId　地域ID
     * 
     **/
    public function findByAreaIdAndMainObjectId($mainObjectId,$areaId) :array
    {
        $items = \DB::table($this->table)->where('objective_id',$mainObjectId)->where('area_id',$areaId)->get()->toArray();
        return $items;
    }

        /**
     * 目的: 目的地リストを県コード・副目的別に取得
     * @param int $mainObjectId　主目的ID
     * @param int $subObjectId　副目的ID
     * @param int $areaId　地域ID
     * 
     **/
    public function findByAreaIdAndSubObjectId($mainObjectId,$subObjectId,$areaId) :array
    {
        $items = \DB::table($this->table)->where('objective_id',$subObjectId)->where('area_id',$areaId)
        ->whereNotIn('name',function ($query) use($mainObjectId){
            $query->select('name')->from($this->table)->where('objective_id',$mainObjectId);
        })->get()->toArray();
        return $items;
    }

    /**
     * 目的: 目的地リストを保存
     * @param array $dataList　目的地リスト
     **/
    public function saveList($dataList) :void
    {
        \DB::table($this->table)->insert($dataList);
    }

    /**
     * 目的: 目的地リストを地域ID別に削除
     * @param int $areaId　地域ID
     **/
    public function deleteByAreaId($areaId) :void
    {
        \DB::table($this->table)->where('area_id',$areaId)->delete();
    }

    /**
     * 目的: 目的地リストから目的地域と違うデータを削除
     * @param String $area 地域名
     * @param int $areaId 地域ID
     **/
    public function deleteByArea($area,$areaId) :void
    {
        \DB::table($this->table)->where('area_id',$areaId)->where('address','not like',"%{$area}%")->delete();
    }
}
