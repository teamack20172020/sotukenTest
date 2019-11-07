<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Placekeyword;
use App\Models\Placelist;
use App\Models\Master;
use App\Http\Service\googleApiService;

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
        $kbn = 1;
        //対象都道府県の目的地リストの削除
        $placelist->deleteByAreaId($areaId);
        //目的地候補リストの取得用キーワードを検索
        $items = $placekeyword->findByAreaId($areaId);
        //県コードから県名を取得
        $area = $master->findByKbnAndSubId($kbn,$areaId)[0]->sub_name;
        //キーワードごとに処理
        for($i=0;$i<count($items);$i++){
            //googleapiで目的地候補リストの取得
            $googleApi = new googleApiService();
            $res = $googleApi->getPlaceList($area,$items[$i]->keyword);
            $insData = array();
            //目的地候補ごとに処理
            for($j=0;$j<count($res);$j++){
                $detailInfo =  $googleApi->getPlaceDetail($res[$j]->formatted_address);
                array_push($insData ,
                    ["name"=>$res[$j]->name ,
                    "objective_id"=>$items[$i]->objective_id,
                    "address"=>$res[$j]->formatted_address,
                    "area_id"=>$areaId,
                    "tell_number"=>$detailInfo->number
                    ]);
            }
            //データベースに目的地候補リストを登録
            $placelist->savelist($insData);
        }
    }
}
