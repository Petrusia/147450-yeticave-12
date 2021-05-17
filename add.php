<?php
require_once('functions/initialize.php');
$title = 'Добавление лота';
session_start();
$isAuth = isAuth();
$userName = $_SESSION['userName'];

if(!$isAuth){
    http_response_code(403);
    header("Location: login.php");
    exit;
}
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
