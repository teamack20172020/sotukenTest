<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Config;

class googleApiController extends apiController
{

    public function getPlaceList($area,$objective){
        $keyword = $area . "　" . $objective;
		$baseUrl = 'https://maps.googleapis.com/maps/api/place/textsearch/';
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		$results = $this->post($baseUrl,$param);
		return $results;
    }
	
	public function getDirectionList($from,$to){
        //$keyword = $area + "　" + $objective;
		$baseUrl = 'https://maps.googleapis.com/maps/api/directions/';
		$param    = [
		//	'query' => $keyword,
		//	'language' => "ja",
		];
		return post($baseUrl,$param);
	}
	
    private function post($baseUrl,$param){
		$type = true;
		$key = 'AIzaSyBezdwuYFibJdo7TIjPJb_dbyq7Wi-vhfg';
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
