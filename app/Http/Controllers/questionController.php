<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Objective;

/*
 *　質問に応じて目的を取得する処理
 * 
*/
class questionController extends Controller
{
    //
    public function getQuestionList(){	
        $question = new Question();
        $items = $question->getAll();
        return $items;
    }

    public function getObjectiveList(){	
        $objective = new objective();
        $items = $objective->getAll();
        return $items;
    }
}
