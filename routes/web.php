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

//候補地リストの更新　引数：目的地/目的
Route::get('/place/saveList/{areaId}', 'placesController@savePlaceList');
//目的リストの取得
Route::get('/objective/getList', 'placesController@getObjectiveList');
//質問リストの取得 引数：
Route::get('/question/getList', 'questionController@getQuestionList');
//質問回答パラメタの保存
Route::get('/questionparam/save/{objectiveId}/{answer}', 'questionController@saveQuestionAnalyze');
//旅行プランの作成
Route::get('/travelplan/create/{objectiveId}/{areaId}', 'travelplanController@createTravelPlan');



