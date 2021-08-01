<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';


$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_VALIDATE_INT);

if (!$lotId ) {
    httpError($categories, '', 404);
}

$lot = getLotById($db, $lotId);
$title = $lot['lot_name'];

echo renderTemplate(
    'lot-template.php', $title, $authUser, $categories, [
        'categories' => $categories,
        'lot' => $lot,
       ]
);
