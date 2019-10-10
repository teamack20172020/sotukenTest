<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionanalyze extends Model
{
    protected $table = 'questionanalyze';

    public function getMaxAnswerId(){
        return intval(\DB::table($this->table)->max("answer_id"));
    }
    
    public function saveList($dataList){
        \DB::table($this->table)->insert($dataList);
    }
}
