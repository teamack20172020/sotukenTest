<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    //
    protected $table = 'master';
    //kbnとsub_Idに一致するmasterのデータ取得
    public function findByKbnAndSubId($kbn,$sub_Id){	
        $items = \DB::table($this->table)->where('kbn',$kbn)->where('sub_id',$sub_Id)->get();
        return $items;
    }

}
