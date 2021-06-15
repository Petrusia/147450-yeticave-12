<?php
require_once('functions/initialize.php');

session_start();
$isAuth = isAuth();
$userName = $_SESSION['userName'];

$title = 'Главная страница';
$db = getDb();
$categories = getCategories($db);
$lots = getLots($db);


$main = include_template(
    'main-template.php',
    [
        'categories' => $categories,
        'lots' => $lots,
    ]
);

$layout = include_template(
    'layout-template.php',
    [
        'scriptName' => $scriptName,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $isAuth,
        'userName' => $userName,
        'title' => $title
    ]
);
print ($layout);
