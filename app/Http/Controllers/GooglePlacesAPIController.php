<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePlacesAPIController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getPlaceList(){	
        $this->init();
		$list  = $this->placelist;
		$results = array();
		foreach((array) $list as $value){
			array_push($results , $value);
		}
		return $results;
    }
    
    private function init(){
        $keyword = "ランチ　香川県";
		$baseUrl = "https://maps.googleapis.com/maps/api/place/textsearch/";
		$key = "AIzaSyDdNwvpwNP85oA8D2P9eGXEMp_WYAL4w1Y";
		$type = true;
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		parent::__construct($baseUrl,$key,$type,$param);
		$list = json_decode($this->requestApi());
		$this->placelist = $list->results;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
