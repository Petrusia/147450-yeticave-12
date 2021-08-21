<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

// Проверяйте существование параметра запроса с ID лота.
$lotId = filter_input(INPUT_GET, 'lot_id', FILTER_VALIDATE_INT);

// Если параметр запроса отсутствует, то вместо содержимого страницы возвращать код ответа 404.
if (!$lotId ) {
    httpError($categories,  $authUser,404);
}
// Сформируйте и выполните SQL-запрос на чтение записи из таблицы с лотами,
// где ID лота равен полученному из параметра запроса.
$lot = getLotById($db, $lotId);
// Если по этому ID не нашли ни одной записи, то вместо содержимого страницы возвращать код ответа 404.
if (!$lot) {
    httpError($categories, $authUser,404);
}
$title = $lot['lot_name'];
$bets = getBetsByLotId($db, $lotId);
$currentPrice = $bets[0]['bet_price'] ?? $lot['lot_price'];
$minBetStep = $currentPrice + $lot['lot_bet_step'];

// Блок добавления ставки не показывается если:
// - пользователь не авторизован - проверяем $authUser;
// - срок размещения лота истёк;
$TermExpired = time() >= strtotime($lot['lot_end']);

// - лот создан текущим пользователем;
$createdByCurrentUser = (isset($authUser['user_id'])) == $lot['lot_author_id'];

// - последняя ставка сделана текущим пользователем.
$lastBetByCurrentUser = (isset($authUser['user_id'])) == (isset($bets[0]['bet_author_id']));

$showBetForm = $authUser && !$TermExpired && !$createdByCurrentUser && !$lastBetByCurrentUser;


$formErrors = [];
$submittedData = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (($_SESSION['token'] !== $_POST['token']) || !$showBetForm){
        httpError($categories, $authUser,403);
    }
    // этап 1: принять все данные формы:
    $submittedData = [
        'cost' => filter_input(INPUT_POST, 'cost'),
    ];
    // этап 2: проверить данные запроса:
    $formErrors = [
        'cost' => validateNumber($submittedData['cost'],
            NUMBER_ERR,
            BET_ERR,
            BET_REQUIRED,
            $minBetStep,
            BET_MIN_LENGTH_ERR . $minBetStep . ' ₽')
    ];
    $formErrors = array_filter($formErrors);
    if (count($formErrors) === 0) {
        saveBetData($db, $submittedData, $authUser, $lotId);
        header("Location: /lot.php?lot_id={$lotId}");
        exit;
    }
}


echo renderTemplate(
    'lot-template.php', $title, $authUser, $categories, [
        'authUser' => $authUser,
        'categories' => $categories,
        'lot' => $lot,
        'bets' => $bets,
        'currentPrice' => $currentPrice,
        'minBetStep' => $minBetStep,
        'showBetForm' => $showBetForm,
        'formErrors' => $formErrors,
        'submittedData' => $submittedData,
       ]
);
