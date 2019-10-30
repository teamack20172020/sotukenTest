<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 質問ポイントテーブルへの操作
class Questionpoint extends Model
{
    // テーブル名
    protected $table = 'questionpoint';

    /**
     * 目的: 質問の回答結果によっておすすめの目的を上位３件を取得
     * @param　array $answerList 回答結果
     **/
    public function getAnswerRes($answerList) :array
    {
        $items = \DB::table($this->table)
            ->select(\DB::raw('objective_id , sum(point) as sum_point'))
            ->where(function ($query) use($answerList){
                for($i=0;$i<count($answerList);$i++){
                    $question_id = intval(substr($answerList[$i],0,4));
                	$answerFlg = intval(substr($answerList[$i],-1,1));
                    $query->orWhere(function ($query_sub)  use($question_id,$answerFlg){

                        $query_sub->where('question_id', $question_id)->where('answerfig', $answerFlg);
                    });
                }
            })
            ->groupBy('objective_id')
            ->latest('sum_point')
            ->limit(3)
            ->get()->toArray();
        return $items;
    }
}
