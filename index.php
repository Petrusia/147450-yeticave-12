<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$isIndex = true; //Используем в  main-header__logo в  layout-template.php
$title = 'Главная страница';

$lots = getLots($db);
foreach ($lots as $key => $lot) {

    $bets = getBetsByLotId($db, $lot['lot_id']);
    $lots[$key]['lot_price'] = $bets[0]['bet_price'] ?? $lot['lot_price'];
    $lots[$key]['count_bets'] = count($bets);
}

echo renderTemplate('index-template.php', $title, $authUser, $categories, [
    'categories' => $categories,
    'lots' => $lots,
], $isIndex);

