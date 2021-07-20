<?php

// https://www.php.net/manual/ru/language.types.declarations.php
declare(strict_types=1);
// https://github.com/ro-htmlacademy/textbook/blob/main/appendix1.md
error_reporting(E_ALL); // задаем максимальный уровень, чтобы РНР нас информировал обо ВСЕХ ошибках без исключений
ini_set('display_errors', '1'); // задаем режим вывода на экран

session_start();

$isIndex = $_SERVER['SCRIPT_NAME'];
date_default_timezone_set('Europe/Vilnius');
const PROJECT_ROOT = __DIR__;
const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php

if (!file_exists('functions/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}
$config = require __DIR__ . '/functions/config.php';
require __DIR__ . '/functions/helpers.php';
require __DIR__ . '/functions/db.php';
require __DIR__ . '/functions/validation.php';


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(
    $config['db']['host'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['dbname'],
    $config['db']['port']
);
$db->set_charset($config['db']['charset']);


$isAuth = isAuth();
$userName = $_SESSION['userName'] ?? '';
$categories = getCategories($db);

