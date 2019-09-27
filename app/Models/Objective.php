<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    //
    protected $table = 'objective';
    
    public function getAll(){	
        $items = \DB::table($this->table)->get();
        return $items;
    }
}
