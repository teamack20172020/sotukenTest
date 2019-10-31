<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * 目的: 目的リストの取得
 * 引数: なし
 **/
Route::get('/objective/getList', 'objectiveController@getObjectiveList');

/**
 * 目的: 質問リストの作成
 * 引数: なし
 **/
Route::get('/question/getList', 'questionController@getQuestionList');

/**
 * 目的: データ収集を目的とした回答結果の保存
 * 引数: objectiveId 目的ID
 *       answer 回答結果
 **/
Route::get('/questionparam/save/{objectiveId}/{answer}', 'questionController@saveQuestionAnalyze');

/**
 * 目的: 質問の回答に応じたおすすめ目的リストの取得
 * 引数: answer 回答結果
 **/
Route::get('/answer-objective/getList/{answer}', 'questionController@getQuestionRes');

/**
 * 目的: 旅行プランの作成
 * 引数: spoint_name 出発地名
 *       spoint　出発地座標（緯度,経度）
 *       objectiveId　目的ID
 *       areaId　地域ID
 **/
Route::get('/travelplan/create/{spoint_name}/{spoint}/{main_objectiveId}/{sub_objectiveId}/{areaId}', 'travelplanController@getTravelPlan');

