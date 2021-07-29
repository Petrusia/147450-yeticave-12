<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_SANITIZE_NUMBER_INT);

if (!$lotId) {
    http_response_code(404);
    $main = include_template(
        '404-template.php',
        [
            'categories' => $categories,
        ]
    );
}

$lot = getLot($db, $lotId);

$main = include_template(
    'lot-template.php',
    [
        'categories' => $categories,
        'lot' => $lot,
        'isAuth' => $isAuth ?? null
    ]
);


$layout = include_template(
    'layout-template.php',
    [
        'isIndex' => $isIndex,
        'main' => $main,
        'categories' => $categories,
        'isAuth' => $isAuth ?? null,
        'authUser' => $authUser ?? null,
        'title' => $lot['lot_name']

    ]
);
print ($layout);
