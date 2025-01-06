<?php
/**
 * home config
 * 
 * @author      yutao
 * @since       PHP 7.0.1
 * @version     1.0.0
 * @date        2018-1-15 13:09:05
 * @copyright   Copyright(C) bravesoft Inc.
 */
return [
    //menu config
    'homemenu1' => [
        'menu01' => ['name' => '傷害報告', 'url' => '/report/create', 'class' => 'btn_col01', 'sub_name' => '傷害情報登録'],
        //'menu02' => ['name' => '', 'url' => '', 'class' => '', 'sub_name' => ''],
        //'menu03' => ['name' => '', 'url' => '', 'class' => '', 'sub_name' => ''],
        'menu04' => ['name' => '登録リスト', 'url' => '/show', 'class' => 'btn_col02', 'sub_name' => '障害情報閲覧'],
        'menu05' => ['name' => 'ログアウト', 'url' => '/logout', 'class' => 'btn_col04', 'sub_name' => 'logout'],
    ]
];
