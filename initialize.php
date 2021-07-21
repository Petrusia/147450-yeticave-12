<?php

// https://www.php.net/manual/ru/language.types.declarations.php
declare(strict_types=1);

const PROJECT_ROOT = __DIR__;
const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php

if (!file_exists(PROJECT_ROOT . '/config.php')) {
    $msg = 'Создайте файл config.php на основе config.sample.php и внесите туда настройки проекта';
    trigger_error($msg, E_USER_ERROR);
}
$config = require PROJECT_ROOT . '/config.php';

// https://github.com/ro-htmlacademy/textbook/blob/main/appendix1.md
error_reporting(E_ALL); // задаем максимальный уровень, чтобы РНР нас информировал обо ВСЕХ ошибках без исключений
ini_set('display_errors', $config['env_local'] === true ? '1' : '0'); // задаем режим вывода на экран

require PROJECT_ROOT . '/functions/helpers.php';
require PROJECT_ROOT . '/functions/db.php';
require PROJECT_ROOT . '/functions/validation.php';
require PROJECT_ROOT . '/functions/db_connect.php';

date_default_timezone_set($config['timezone']);

// из-за того что session_start(); стоит в самом низу, у некоторых может сильно подгореть. не ведитесь!
//у вас всё абсолютно нормально
//Сессию нельзя стартовать до любого вывода, а в ininialize по определению не должно быть никакого вывода, так что стартовать можно где угодно
//А вот режим вывода ошибок я бы задал как раз повыше.
session_start();
$userName = $_SESSION['userName'] ?? '';
$categories = getCategories($db);