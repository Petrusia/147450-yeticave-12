<?php

require_once('functions/initialize.php');
$scriptName = $_SERVER['SCRIPT_NAME'];
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
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => $lot['lot_name']

    ]
);
print ($layout);
