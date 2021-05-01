<?php

require_once('functions/initialize.php');
$db = getDb();
$categories = getCategories($db);
$lots = getLots($db);


$main = include_template(
    'main.php',
    [
        'categories' => $categories,
        'lots' => $lots,
    ]
);

$layout = include_template(
    'layout.php',
    [
        'main' => $main,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => 'Главная стараница'
    ]
);
print ($layout);
