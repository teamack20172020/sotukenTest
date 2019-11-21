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
        'place_text' => [
            'url' => 'https://maps.googleapis.com/maps/api/place/textsearch/',
            'key' => 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M',
        ],
        'place_detail'=> [
            'url' => 'https://maps.googleapis.com/maps/api/place/details/',
            'key' => 'AIzaSyCSaGHq03_pZW5_xZEXeiJ-zTfxY2AAo7M', 
        ],
        'directions' => [
            'url' => 'https://maps.googleapis.com/maps/api/directions/',
            'key' => 'AIzaSyBezdwuYFibJdo7TIjPJb_dbyq7Wi-vhfg', 
        ],
    ],

    //　DBに関する設定
    'DB' =>[
        'master' => [
            'area' => [
                // マスタ区分
                'kbn' => '1',
                //全国
                'all' => '48',
            ],
            'objectiv_point' => [
                'kbn' => '2',
            ],
            'place_type' => [
                'kbn' => '3',
            ],
        ],
    ],
];
