<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    // GoogleApiに関する設定
    'GoogleApi' => [
        // テキスト検索
        'place_text' => [
            'url' => 'https://maps.googleapis.com/maps/api/place/textsearch/',
            'key' => 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M',
        ],
        // 詳細検索(リファレンスIDをキーに指定)
        'place_detail'=> [
            'url' => 'https://maps.googleapis.com/maps/api/place/details/',
            'key' => 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M', 
        ],
        // ルート検索
        'directions' => [
            'url' => 'https://maps.googleapis.com/maps/api/directions/',
            'key' => 'AIzaSyBezdwuYFibJdo7TIjPJb_dbyq7Wi-vhfg', 
        ],
    ],

    //　DBに関する設定
    'database' =>[
        'master' => [
            // 地域に関する情報（47都道府県）
            'area' => [
                // マスタ区分
                'kbn' => '1',
                //全国
                'all' => '48',
            ],
            // 目的別の重み係数
            'objectiv_point' => [
                'kbn' => '2',
            ],
            // 場所タイプ別の滞在時間
            'place_type' =>[
                'kbn' => '3',
            ],
        ],
    ],

    // プランの作成に関する設定
    'plan_setting' => [
        // 最大滞在時間（単位：秒）
        'stay_scond_max' => 25200,
        // 最低滞在時間（単位：秒）
        'stay_scond_min' => 5200,
    ],
];
