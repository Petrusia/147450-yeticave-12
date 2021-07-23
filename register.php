<?php
require('initialize.php');
$title = 'Регистрация';

$isAuth = isAuth();

// 8. По такому же принципу для залогиненных пользователей
// надо закрыть страницу регистрации.
httpError($isAuth);

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
        'isIndex' => $isIndex,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $isAuth,
        'authUser' => $authUser,
        'title' => $title

    ]
);
print ($layout);
