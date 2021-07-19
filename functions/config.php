<?php
// укажите здесь ваше имя
/** @var  $scriptName */
$scriptName = $_SERVER['SCRIPT_NAME'];
date_default_timezone_set('Europe/Vilnius');
define("PROJECT_ROOT", dirname(__DIR__));
define("WEB_ROOT",  substr($_SERVER['SCRIPT_NAME'], 0, 1));

const DB_HOST = 'db_server';
const DB_USER = 'yeticave';
const DB_PASSWORD = 'secret';
const DB_NAME = 'yeticave';

const DAY = 86400;
