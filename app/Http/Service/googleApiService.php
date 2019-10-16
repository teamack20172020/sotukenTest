<?php

namespace App\Http\Service;

use Illuminate\Http\Request;

class googleApiService extends apiService
{

	public function getPlaceList($area,$objective) :array
	{
        $keyword = $area . "　" . $objective;
		$baseUrl = 'https://maps.googleapis.com/maps/api/place/textsearch/';
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		$key = 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M';
		return (array) $this->post($baseUrl,$param,$key)->results;

	}
	
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
		return (array) $this->post($baseUrl,$param,$key)->routes[0]->legs[0];
	}
	
	private function post($baseUrl,$param,$key) :object
	{
		$type = true;
		parent::__construct($baseUrl,$key,$type,$param);
		$list = json_decode($this->requestApi());
		return $list;
	}
}
