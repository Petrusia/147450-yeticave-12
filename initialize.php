<?php

session_start();

$scriptName = $_SERVER['SCRIPT_NAME'];
date_default_timezone_set('Europe/Vilnius');
const PROJECT_ROOT = __DIR__;
const DAY = 86400;

if (!file_exists('functions/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}
$config = require __DIR__ . '/functions/config.php';
require __DIR__ . '/functions/helpers.php';
require __DIR__ . '/functions/db.php';
require __DIR__ . '/functions/validation.php';


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['dbname'], $config['db']['port']);
$db->set_charset($config['db']['charset']);


