<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionpoint extends Model
{
    //
    protected $table = 'questionpoint';

    public function getAnswerRes($answerList) :array
    {
        $items = \DB::table($this->table)
            ->select(DB::raw('objective_id , sum(point) as sum_point'))
            ->where(function ($query) {
                for($i=0;$i<count($answerList);$i++){
                    $question_id = intval(substr($answerList[$i],0,4));
                    $answerFlg = intval(substr($answerList[$i],-1,1));
                    $query->orWhere(function ($query_sub) {
                        return $query_sub->where('question_id', $question_id)->where('answerfig', $answerFlg);
                    })
                } 
            }
            ->groupBy('objective_id')
            ->having('sum_point', '>', 0)
            ->latest()
            ->get();
    
        return $items;
    }
}
