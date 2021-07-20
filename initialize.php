<?php

// https://www.php.net/manual/ru/language.types.declarations.php
declare(strict_types=1);

const PROJECT_ROOT = __DIR__;

$config = require PROJECT_ROOT . '/functions/config.php';
require PROJECT_ROOT . '/functions/helpers.php';
require PROJECT_ROOT . '/functions/db.php';
require PROJECT_ROOT . '/functions/validation.php';

// https://github.com/ro-htmlacademy/textbook/blob/main/appendix1.md
error_reporting(E_ALL); // задаем максимальный уровень, чтобы РНР нас информировал обо ВСЕХ ошибках без исключений
ini_set('display_errors', $config['env_local'] === true ? '1' : 0); // задаем режим вывода на экран

if (!file_exists('functions/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}

date_default_timezone_set($config['timezone']);

const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php
$isIndex = $_SERVER['SCRIPT_NAME'];  //Используем в  main-header__logo в  layout-template.php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(
    $config['db']['host'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['dbname'],
    $config['db']['port']
);
$db->set_charset($config['db']['charset']);

session_start();
$isAuth = isAuth();
$userName = $_SESSION['userName'] ?? '';
$categories = getCategories($db);

