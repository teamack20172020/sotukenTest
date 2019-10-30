<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//　マスターテーブルへの操作
class Master extends Model
{
    // テーブル名
    protected $table = 'master';
 
    /**
     * 目的: マスタデータを取得
     * @param int $kbn　メイン区分
     * @param int $sub_Id サブ区分
     * 
     **/
    public function findByKbnAndSubId($kbn,$sub_Id) :array
    {
        $items = \DB::table($this->table)->where('kbn',$kbn)->where('sub_id',$sub_Id)->get()->toArray();
        return $items;
    }
}
