<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

// Проверяйте существование параметра запроса с ID лота.
$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_VALIDATE_INT);

// Если параметр запроса отсутствует, то вместо содержимого страницы возвращать код ответа 404.
if (!$lotId ) {
    httpError($categories,  404);
}
// Сформируйте и выполните SQL-запрос на чтение записи из таблицы с лотами,
// где ID лота равен полученному из параметра запроса.
$lot = getLotById($db, $lotId);
// Если по этому ID не нашли ни одной записи, то вместо содержимого страницы возвращать код ответа 404.
if (!$lot) {
    httpError($categories, 404);
}
$title = $lot['lot_name'];
$bets = getBetsByLotId($db, $lotId);
$currentPrice = $bets[0]['bet_price'] ?? $lot['lot_price'];
$minBetStep = $currentPrice + $lot['lot_bet_step'];


echo renderTemplate(
    'lot-template.php', $title, $authUser, $categories, [
        'authUser' => $authUser,
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'currentPrice' => $currentPrice,
        'minBetStep' => $minBetStep,
       ]
);
