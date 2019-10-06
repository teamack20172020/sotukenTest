<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class googleApiController extends apiController
{

    public function getPlaceList($area,$objective){
        $keyword = $area . "　" . $objective;
		$baseUrl = Config::get('apisetting.GoogleApi.place_text_url');
		$param    = [
			'query' => $keyword,
			'language' => "ja",
		];
		return post($baseUrl,$param);
    }
	
	public function getDirectionList($from,$to){
        //$keyword = $area + "　" + $objective;
		$baseUrl = Config::get('apisetting.GoogleApi.directions_url');
		$param    = [
		//	'query' => $keyword,
		//	'language' => "ja",
		];
		return post($baseUrl,$param);
	}
	
    private function post($baseUrl,$param){
		$type = true;
		$key = Config::get('api.GoogleApi.key');
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
