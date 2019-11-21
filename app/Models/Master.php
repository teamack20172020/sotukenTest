<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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

    /**
     * 目的: 場所タイプ別滞在時間のマスタデータを取得
     * @param array $place_type_list 場所リスト
     **/
    public function findByKbnAndSubIdList($place_type_list) :array
    {
        $items = \DB::table($this->table)
        ->select(\DB::raw('kbn , IFNULL(max(int_field01),' . config('api.plan_setting.stay_scond_min') . ')  as stay_time'))
        ->where('kbn',config('api.database.master.place_type.kbn'))
        ->whereIn('str_field01',$place_type_list)
        ->groupBy('kbn')
        ->get()->toArray();
        return $items;
    }

}
