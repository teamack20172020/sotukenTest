<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

//　目的地リスト検索用キーワードテーブルへの操作
class Placekeyword extends Model
{
    // テーブル名
    protected $table = 'placekeyword';
    
    /**
     * 目的: 目的地リスト検索用キーワードリストを取得
     * @param int $areaId　地域ID
     * 
     **/
    public function findByAreaId($areaId) :array
    {
       $items = \DB::table($this->table)->whereIn('area_id',[$areaId,config('api.database.master.area.all')])->get()->toArray();
        return $items;
    }
}
