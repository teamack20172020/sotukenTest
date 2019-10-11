<?php

namespace App\Http\Service;

use Illuminate\Http\Request;
use app\Config;

class googleApiService extends apiService
{

    public function getPlaceList($area,$objective){
        $keyword = $area . "　" . $objective;
		$baseUrl = 'https://maps.googleapis.com/maps/api/place/textsearch/';
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		return $this->post($baseUrl,$param);
	}
	
	public function getDirectionList($origin,$destination,$mode,$departure_time){
		$baseUrl = 'https://maps.googleapis.com/maps/api/directions/';
		$param    = [
			'origin' => $origin,
			'destination' => $destination,
			'mode ' => $mode,
			'departure_time' => $departure_time,
			'traffic_model' => 'pessimistic',
			'language' => "ja",
		];
		return $this->post($baseUrl,$param);
	}
	
    private function post($baseUrl,$param){
		$type = true;
		$key = 'AIzaSyBCH09CchIgy75iIvVbUqDMQPv8M1SZdC0';
		parent::__construct($baseUrl,$key,$type,$param);
		$list = json_decode($this->requestApi());
		$this->placelist = $list->results;
		
		$list  = $this->placelist;
		$results = array();
		foreach((array) $list as $value){
			array_push($results , $value);
		}
		return $results;
    }

}
