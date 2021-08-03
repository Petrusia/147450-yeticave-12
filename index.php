<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$isIndex = true; //Используем в  main-header__logo в  layout-template.php
$title = 'Главная страница';
$lots = getLots($db);
$bets = getBets($db);

echo renderTemplate('index-template.php', $title, $authUser, $categories, [
    'categories' => $categories,
    'lots' => $lots,
    'bets' => $bets
], $isIndex);

