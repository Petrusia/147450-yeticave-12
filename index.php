<?php

require __DIR__ . '/initialize.php';

$title = 'Главная страница';
$lots = getLots($db);

echo renderTemplate('index-template.php',$title, $isIndex, $isAuth, $userName, $categories, ['categories' => $categories,'lots' => $lots]);

