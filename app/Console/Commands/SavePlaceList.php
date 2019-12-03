<?php

namespace App\Console\Commands;

use App\Models\Master;
use App\Models\Placelist;
use App\Models\Placekeyword;
use Illuminate\Console\Command;
use App\Http\Service\googleApiService;
use Illuminate\Support\Facades\Config;

class SavePlaceList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:savePlaceList';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'savePlaceList';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $areaId=37;
        //id 県コード
        $placelist = new Placelist();
        $placekeyword = new Placekeyword();
        $master = new Master();
        //目的地リストから一番最後に作成された時間を取得(県コード毎)
        $time = $placelist->findByAreaId($areaId)[0]->time;
        //目的地候補リストの取得用キーワードを検索
        $items = $placekeyword->findByAreaId($areaId);
        //県コードから県名を取得
        $area = $master->findByKbnAndSubId(config('api.database.master.area.kbn'),$areaId)[0]->sub_name;
        //キーワードごとに処理
        for($i=0;$i<count($items);$i++){
            //googleapiで目的地候補リストの取得
            $googleApi = new googleApiService();
            $res = $googleApi->getPlaceList($area,$items[$i]->keyword);
            $insData = array();
            //目的地候補ごとに処理
            for($j=0;$j<count($res);$j++){
                //目的地の詳細情報を取得
                $detailInfo =  $googleApi->getPlaceDetail($res[$j]->place_id);

                // 詳細情報が存在しなければ処理をスキップする
                if(is_null($detailInfo)){
                    continue;
                }

                //formatted_phone_number(電話番号)が設定されていなければ空白を挿入
                if(isset($detailInfo['formatted_phone_number'])){
                    $phone_number = $detailInfo['formatted_phone_number'];
                }else{
                    $phone_number = "";
                }

                //websiteが登録されていなければGoogleMapのurlを使用
                if(isset($detailInfo['website'])){
                    $site_url = $detailInfo['website'];
                }else{
                    $site_url = $detailInfo['url'];
                }

                //typeによって滞在時間を設定､typeがデータになければ固定値を設定
                $stay_info = $master->findByKbnAndSubIdList($detailInfo['types']);
                if(count($stay_info)>0){
                    $stay_time = $stay_info[0]->stay_time;
                }else{
                    $stay_time = config('api.plan_setting.stay_scond_min');
                }

                array_push($insData ,
                    ["name"=>$res[$j]->name ,
                    "objective_id"=>$items[$i]->objective_id,
                    "address"=>$res[$j]->formatted_address,
                    "lat"=>$res[$j]->geometry->location->lat,
                    "lng"=>$res[$j]->geometry->location->lng,
                    "stay_second"=>$stay_time,
                    "area_id"=>$areaId,
                    "phone_number"=>$phone_number,
                    "site_url"=>$site_url,
                    "types"=>implode( ",",$detailInfo['types']),
                    ]);
            }
            //データベースに目的地候補リストを登録
            $placelist->savelist($insData);
        }
        if(!is_null($time)){
            //対象都道府県の目的地リストの削除
            $placelist->deleteByAreaIdAndTime($areaId,$time);   
        }
        //目的地域が違うデータを削除する処理
        $placelist->deleteByAreaIdAndArea($area,$areaId);
    }
}
