<?php
namespace App\Http\Service;

use Illuminate\Http\Request;

class apiService {

	//APIURL
	protected  $baseUrl;
	//APIKEY
	protected  $key;
	//通信タイプ（GET:true POST:false）
	protected  $type;
	//リクエストパラメター(形式：['key'=>value])
	protected  $requestparam;

	/*
	 * コンストラクタ
	 * @parm $url APIのURL
	 * @parm $key APIのKEY
	 * @parm $type 通信タイプ（GET:true POST:false）
	 * @parm $requestparam リクエストパラメター(形式：['key'=>value])
	 *
	*/
	public function __construct($url = "",$key = "",$type = false,$requestparam = []){
		$this->baseUrl = $url;
		$this->type = $type;
		$this->requestparam = array_merge($requestparam,array('key'=> $key));
	}


	public function requestApi() :string
	{
        $fileType = "json";
        $query = http_build_query($this->requestparam);
        $url   = $this->baseUrl.$fileType.'?'.$query;
        // fire
        $curl = curl_init($url);
        $options = [
          CURLOPT_HTTPGET => $this->type,//GET
          CURLOPT_RETURNTRANSFER => true // fetch datum as strings
        ];
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
		$result = array();
		foreach((array) $response as $value){
			array_push($result , $value);
		}
		return $result[0];
    }
}
