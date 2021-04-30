<?php

require_once('functions/initialize.php');

$main = include_template(
    'main.php',
    [
        'categories' => $categories,
        'items' => $items,
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
