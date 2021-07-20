<?php

require __DIR__ . '/initialize.php';

$title = 'Главная страница';
$lots = getLots($db);

echo renderTemplate('index-template.php', $title, $isAuth, $userName, $categories,  $isIndex, [
    'categories' => $categories,
    'lots' => $lots
]);

