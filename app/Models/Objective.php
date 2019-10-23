<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    protected $table = 'objective';
    public function getAll() :array
    {
        $items = \DB::table($this->table)->get()->toArray();
        return $items;
    }
}
