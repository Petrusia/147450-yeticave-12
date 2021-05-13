<?php

require_once('functions/initialize.php');

$db = getDb();
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
        ]
    );
}

$layout = include_template(
    'layout-template.php',
    [
        'scriptName' => $scriptName,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $isAuth,
        'userName' => $userName,
        'title' => $lot['lot_name']

    ]
);
print ($layout);
