<?php
require_once('functions/initialize.php');
$title = 'Вход';
session_start();
$isAuth = isAuth();

if($isAuth){
    http_response_code(403);
    header("Location: /");
    exit;
}

$db = getDb();
$categories = getCategories($db);
$loginInput = [];
$errors =[];
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
'scriptName' => $scriptName,
'main' => $main,
'categories' => $categories,
'isAuth' => $isAuth,
'userName' => $userName,
'title' => $title

]
);
print ($layout);
