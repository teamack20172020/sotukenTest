<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    public function getAll() :array
    {
        $items = \DB::table($this->table)->get()->toArray();
        return $items;
    }
}
