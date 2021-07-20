<?php

require('initialize.php');

$isAuth = isAuth();
$userName = $_SESSION['userName'];

$categories = getCategories($db);
$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_SANITIZE_NUMBER_INT);

if (!$lotId) {
    http_response_code(404);
    $main = include_template(
        '404-template.php',
        [
            'categories' => $categories,
        ]
    );
} else {
    $lot = getLot($db, $lotId);

    $main = include_template(
        'lot-template.php',
        [
            'categories' => $categories,
            'lot' => $lot,
            'isAuth'=>  $isAuth ?? null
        ]
    );
}

$layout = include_template(
    'layout-template.php',
    [
        'isIndex' => $isIndex,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $isAuth ?? null,
        'userName' => $userName ?? null,
        'title' => $lot['lot_name']

    ]
);
print ($layout);
