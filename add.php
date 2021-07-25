<?php

require __DIR__ . '/initialize.php';

$title = 'Добавление лота';

if (!$authUser) {
    httpError($categories, 403);
}
$formErrors = [];
$submittedData = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submittedData = $_POST;
    $submittedFile = $_FILES;
    // этап 1: проверить данные запроса:
    $formErrors = validatedLotData($submittedData, $submittedFile, $categories);

    // этап 2: сохранить проверенные данные если соответствует правилам валидации:
    if (count($formErrors) === 0) {
        $normalizedData = normalizedLotData($submittedData);
        $normalizedData = imageUpload($submittedFile, $normalizedData );
        saveLotData($db, $normalizedData, $authUser);
    }
}

echo renderTemplate(
    'add-template.php', $title, $authUser, $categories, [
        'categories' => $categories,
        'formErrors' => $formErrors,
        'normalizedData' => $submittedData,


    ]
);

