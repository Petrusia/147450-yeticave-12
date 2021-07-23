<?php

require __DIR__ . '/initialize.php';
$title = 'Вход';


// 8. По такому же принципу для залогиненных пользователей
// надо закрыть страницу регистрации.
$loginInput = [];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginInput = getLoginInput();
    $errors = getLoginErrors($db);
    if (empty($errors)) {
        setSession($db, $loginInput['user-email']);
    }
}


$main = include_template(
    'login-template.php',
    [
        'categories' => $categories,
        'errors' => $errors,
        'loginInput' => $loginInput
    ]
);


$layout = include_template(
    'layout-template.php',
    [
        'isIndex' => $isIndex,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $authUser,
        'authUser' => $authUser,
        'title' => $title

    ]
);
print ($layout);
