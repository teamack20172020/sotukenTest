<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 質問テーブルへの操作
class Question extends Model
{
    protected $table = 'question';

    /**
     * 目的: 質問リストの取得
     * 引数: なし
     **/
    public function getAll() :array
    {
        $items = \DB::table($this->table)->get()->toArray();
        return $items;
    }
}
