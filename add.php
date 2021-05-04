<?php

require_once('functions/initialize.php');
$db = getDb();
$categories = getCategories($db);


$main = include_template(
    'add-template.php',
    [
        'categories' => $categories,
        'lot' => $lot,
    ]
);


$layout = include_template(
    'lot-layout.php',
    [
        'main' => $main,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => 'Добавление лота'

    ]
);
print ($layout);
