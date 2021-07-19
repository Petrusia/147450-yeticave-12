<?php

require __DIR__ . '/initialize.php';

$isAuth = isAuth();
$userName = $_SESSION['userName'] ?? null;

$title = 'Главная страница';
$categories = getCategories($db);
$lots = getLots($db);


//$main = include_template(
//    'main-template.php',
//    [
//        'categories' => $categories,
//        'lots' => $lots,
//    ]
//);
//
//$layout = include_template(
//    'layout-template.php',
//    [
//        'scriptName' => $scriptName,
//        'main' => $main,
//        'categories' => $categories,
//        'isAuth' => $isAuth ?? null,
//        'userName' => $userName,
//        'title' => $title
//    ]
//);

$content = render(
    'main-template.php',
    [
        'scriptName' => $scriptName,
        'lots' => $lots,
        'categories' => $categories,
        'isAuth' => $isAuth ?? null,
        'userName' => $userName,
        'title' => $title
    ]
);
echo $content;
