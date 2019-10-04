<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionparam extends Model
{
    //
    protected $table = 'questionparam';

    public function saveRow($questionparam,$objectiveId){
        \DB::table($this->table)->insert([
            'parameter'=>$questionparam ,
            'objective_id'=>$objectiveId 
        ]);
    }
}
