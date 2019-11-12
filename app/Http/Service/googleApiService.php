<?php

namespace App\Http\Service;

use Illuminate\Http\Request;

// GoogleAppiへの操作
class googleApiService extends apiService
{
	/**
	 * 目的: GooglePlaceAPIを利用して目的地リストを取得
	 * @param String $area 地域ID
	 * @param String $objective 目的ID
	 *
	 **/
	public function getPlaceList($area,$objective) :array
	{
        $keyword = $area . "&&" . $objective;
		$baseUrl = 'https://maps.googleapis.com/maps/api/place/textsearch/';
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		$key = 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M';
		return (array) $this->post($baseUrl,$param,$key)->results;
	}

	/**
	 * 目的: GooglePlaceAPIを利用して施設詳細情報を取得
	 * @param String $placeId 場所ID
	 *
	 **/
	public function getPlaceDetail($placeId) :array
	{
		$baseUrl = 'https://maps.googleapis.com/maps/api/place/details/';
		$param    = [
			'place_id' => $placeId,
			'language' => "ja",
		];
		$key = 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M';
		
		return (array) $this->post($baseUrl,$param,$key)->result;
	}
	
	/**
	 * 目的: GoogleDirectionAPIを利用してルートを取得
	 * @param String $origin 出発地
	 * @param String $destination 目的地
	 *
	 **/
	public function getDirectionList($origin,$destination) :array
	{
		$baseUrl = 'https://maps.googleapis.com/maps/api/directions/';
		$param    = [
			'origin' => $origin,
			'destination' => $destination,
			//'mode ' => $mode,
			//'departure_time' => $departure_time,
			//'traffic_model' => 'pessimistic',
			'language' => "ja",
		];
		$key = 'AIzaSyBezdwuYFibJdo7TIjPJb_dbyq7Wi-vhfg';
		return (array) $this->post($baseUrl,$param,$key)->routes;
	}
	
	/**
	 * 目的: GoogleAPIへリクエストの送信
	 * @param String $baseUrl APIのURL
	 * @param String $param APIのリクエストパラメタ
	 * @param key $param APIKEY
	 *
	 **/
	private function post($baseUrl,$param,$key) :object
	{
		$type = true;
		parent::__construct($baseUrl,$key,$type,$param);
		$list = json_decode($this->requestApi());
		return $list;
	}
}
