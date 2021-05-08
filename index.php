<?php
require_once('functions/initialize.php');
$scriptName = $_SERVER['SCRIPT_NAME'];
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
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => $title
    ]
);
print ($layout);
