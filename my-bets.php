<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Мои ставки';

if (!$authUser) {
    httpError($categories, $authUser,403);
}

$lots = getMyBets($db, $authUser['user_id']);

echo renderTemplate('my-bets-template.php', $title, $authUser, $categories, [
    'categories' => $categories,
    'lots' => $lots,
    'authUser' => $authUser
]);


