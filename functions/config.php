<?php
$is_auth = rand(0, 1);
$user_name = 'Petras'; // укажите здесь ваше имя
date_default_timezone_set('Europe/Vilnius');
//define("PATH", dirname(__FILE__));
define("PROJECT_ROOT", dirname(__DIR__));
define("WEB_ROOT",  substr($_SERVER['SCRIPT_NAME'], 0, 1));

define('DB_HOST', 'mysql');
define('DB_USER', 'yeti');
define('DB_PASSWORD', 'secret');
define('DB_NAME', 'yetidb');
