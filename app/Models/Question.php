<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 質問テーブルへの操作
class Question extends Model
{
    // テーブル名
    protected $table = 'question';

    /**
     * 目的: 質問リストの取得
     * 
     **/
    public function getAll() :array
    {
        $items = \DB::table($this->table)->get()->toArray();
        return $items;
    }
}
