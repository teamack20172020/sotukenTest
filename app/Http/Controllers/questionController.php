<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Questionpoint;
use App\Models\Questionanalyze;

//　質問に関する操作
class questionController extends Controller
{
    /**
	 * 目的:質問リストの取得
	 *
	 **/
    public function getQuestionList() :array
    {
        $question = new Question();
        $items = $question->getAll();
        return $items;
    }

    /**
	 * 目的: 回答結果に応じた目的リストの取得
	 * @param String $answer 回答結果
	 *
	 **/
    public function getQuestionRes($answer) :array
    {
        $answerList = explode("q",$answer);
        $questionpoint = new Questionpoint();
        $items = $questionpoint->getAnswerRes($answerList);
        return $items;
    }

    /**
	 * 目的: データ収集結果の保存
	 * @param String $objectiveId  目的地ID
	 * @param String $answer 回答結果
	 *
	 **/
    public function saveQuestionAnalyze($objectiveId,$answer) :void
    {
        $questionanalyze = new Questionanalyze();
        $maxId = $questionanalyze->getMaxAnswerId() + 1;
        $answerList = explode("q",$answer);
        $insData = [];
        for($i=0;$i<count($answerList);$i++){
            $question_id = intval(substr($answerList[$i],0,4));
            $answerFlg = substr($answerList[$i],-1,1);
            array_push($insData ,[
                            "answer_id"=>$maxId,
                            "objective_id"=>$objectiveId,
                            "question_id"=>$question_id,
                            "answer"=>$answerFlg]);
        }
        $questionanalyze->saveList($insData);
    }
}
