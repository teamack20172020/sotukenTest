<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;

/*
 *　目的と目的地に関する操作
 *
*/
class objectiveController extends Controller
{
    public function getObjectiveList() :object
    {
        $objective = new Objective();
        $items = $objective->getAll();
        return $items;
    }
}
