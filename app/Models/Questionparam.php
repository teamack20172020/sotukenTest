<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionparam extends Model
{
    //
    protected $table = 'questionparam';

    public function saveRow($objectiveId,$questionparam){
        \DB::table($this->table)->insert([
            'objective_id'=>$objectiveId ,
            'parameter'=>$questionparam ,
        ]);
    }
}
