<?php

require_once('functions/initialize.php');
$scriptName = $_SERVER['SCRIPT_NAME'];
$title = 'Добавление лота';

$db = getDb();
$categories = getCategories($db);
$lotInput = [];
$errors =[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lotInput = getLotInput();
    $errors = getErrors();
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
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => $title

    ]
);
print ($layout);
