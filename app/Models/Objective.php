<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//目的テーブルへの操作
class Objective extends Model
{
    // テーブル名
    protected $table = 'objective';

    /**
     * 目的: 目的リストを取得
     * 
     **/
    public function getAll() :array
    {
        $items = \DB::table($this->table)->get()->toArray();
        return $items;
    }
}
