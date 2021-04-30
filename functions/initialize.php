<?php
$is_auth = rand(0, 1);
$user_name = 'Petras'; // укажите здесь ваше имя
date_default_timezone_set('Europe/Vilnius');
//define("PATH", dirname(__FILE__));
define("PROJECT_ROOT", dirname(__DIR__));
define("WEB_ROOT",  substr($_SERVER['SCRIPT_NAME'], 0, 1));

$categories = [
    "Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"
];

$items =  [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 10999,
        'image_url' => 'img/lot-1.jpg',
        'expire_at' => '2021-05-02'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => 159999,
        'image_url' => 'img/lot-2.jpg',
        'expire_at' => '2021-05-05'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => 8000,
        'image_url' => 'img/lot-3.jpg',
        'expire_at' => '2021-05-01'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => 10999,
        'image_url' => 'img/lot-4.jpg',
        'expire_at' => '2021-05-03'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => 7500,
        'image_url' => 'img/lot-5.jpg',
        'expire_at' => '2021-05-07'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => 5400,
        'image_url' => 'img/lot-6.jpg',
        'expire_at' => '2021-05-05'
    ]
];

require_once(PROJECT_ROOT . '/helpers.php');
require_once('validation.php');
require_once('date.php');

