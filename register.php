<?php
require_once('functions/initialize.php');
$title = 'Регистрация';

$db = getDb();
$categories = getCategories($db);
$registerInput = [];
$errors =[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registerInput = getRegisterInput();
    $errors = getRegisterErrors($db);
    if (empty($errors)) {
        registerUser($db, $registerInput);
    }

}


$main = include_template(
    'register-template.php',
    [
        'categories' => $categories,
        'errors' => $errors,
        'registerInput' => $registerInput
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
