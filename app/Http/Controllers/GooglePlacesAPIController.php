<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePlacesAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = "温泉";
        $baseUrl = "https://maps.googleapis.com/maps/api/place/textsearch/";
        //$baseUrl = "https://maps.googleapis.com/maps/api/place/findplacefromtext/";
        $fileType = "json";
        $query    = [
            'key' => "AIzaSyDdNwvpwNP85oA8D2P9eGXEMp_WYAL4w1Y",
            'query' => $keyword,
            'language' => "ja",
        ];
        $query = http_build_query($query);
        $url   = $baseUrl.$fileType.'?'.$query;

        // fire
        $curl = curl_init($url);
        $options = [
          CURLOPT_HTTPGET => true,//GET
          CURLOPT_RETURNTRANSFER => true // fetch datum as strings
        ];

        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
		$result = array();
		foreach((array) $response as $value){
			array_push($result , $value);
		}
		return $result;
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
