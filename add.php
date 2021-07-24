<?php

require __DIR__ . '/initialize.php';

$title = 'Добавление лота';

if (!$authUser) {
    httpError($categories, 403);
}

$formErrors = [];
$normalizedData = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // этап 1: привести в порядок  данные запроса:
    $normalizedData = normalizedLotData($_POST, $_FILES);

    // этап 2: проверить  нормализованные данные
    $formErrors = validatedLotData($normalizedData, $categories);

    // этап 3: сохранить проверенные данные если соответствует правилам валидации
    if (count($formErrors) === 0) {
        $normalizedData = imageUpload($normalizedData, $authUser);
        saveLotData($db, $normalizedData, $authUser);
    }
}

echo renderTemplate(
    'add-template.php', $title, $authUser, $categories, [
        'categories' => $categories,
        'formErrors' => $formErrors,
        'normalizedData' => $normalizedData,
        'authUser' => $authUser

    ]
);

