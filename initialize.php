<?php

// https://www.php.net/manual/ru/language.types.declarations.php
declare(strict_types=1);

if (!file_exists('config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки сервера MySQL';
    trigger_error($msg, E_USER_ERROR);
}

// https://github.com/ro-htmlacademy/textbook/blob/main/appendix1.md
error_reporting(E_ALL); // задаем максимальный уровень, чтобы РНР нас информировал обо ВСЕХ ошибках без исключений
const PROJECT_ROOT = __DIR__;

$config = require PROJECT_ROOT . '/config.php';
require PROJECT_ROOT . '/functions/helpers.php';
require PROJECT_ROOT . '/functions/db.php';
require PROJECT_ROOT . '/functions/validation.php';

ini_set('display_errors', $config['env_local'] === true ? '1' : 0); // задаем режим вывода на экран

date_default_timezone_set($config['timezone']);
const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php


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
$userName = $_SESSION['userName'] ?? '';
$categories = getCategories($db);

