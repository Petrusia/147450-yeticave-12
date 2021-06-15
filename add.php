<?php
require_once('functions/initialize.php');
$title = 'Добавление лота';
session_start();
$isAuth = isAuth();
$userName = $_SESSION['userName'];

// 7. Закрыть доступ к странице add.php для анонимных пользователей. При попытке обращения к этой странице
// анонимному пользователю должен возвращаться HTTP-код ответа 403.
closePage(!$isAuth, 'login.php');

$db = getDb();
$categories = getCategories($db);
$lotInput = [];
$errors =[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lotInput = getLotInput();
    $errors = getLotErrors();
    if (empty($errors)) {
        $lotInput['lot-img'] = getImage();
        saveLot($db, $lotInput);
    }

}


$main = include_template(
    'add-template.php',
    [
        'categories' => $categories,
        'errors' => $errors,
        'lotInput' => $lotInput
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
