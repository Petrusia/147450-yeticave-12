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
    $formErrors = [
        'lot-name' => validatedText($submittedData['lot-name'], LOT_NAME_EXIST_ERR, LOT_NAME_LENGTH, LOT_NAME_LENGTH_ERR),
        'lot-category' => validatedCategory($submittedData['lot-category'], $categories, LOT_CATEGORY_ERR),
        'lot-message' => validatedText($submittedData['lot-message'], LOT_MESSAGE_ERR),
        'lot-rate' => validatedInt( $submittedData['lot-rate'],  LOT_RATE_ERR),
        'lot-step' => validatedInt( $submittedData['lot-step'],  LOT_STEP_ERR),
        'lot-date' => validatedDate( $submittedData['lot-date'],  LOT_DATE_EXIST_ERR, LOT_DATE_TIME_ERR),
        'lot-img' => validatedImage( $submittedFile,  LOT_IMG_EXIST_ERR, LOT_IMG_EXT_ERR, LOT_IMG_SIZE_ERR),
    ];


    // этап 2: сохранить проверенные данные если соответствует правилам валидации:
    if (!array_filter($formErrors)) {
        $normalizedData =
            [
                // trim возвращает строку string с удалёнными из начала и конца строки пробелами.
                'lot-name' => trim($submittedData['lot-name']),
                'lot-category' => (int)($submittedData['lot-category']),
                'lot-message' => (trim($submittedData['lot-message'])),
                'lot-rate' => (int)($submittedData['lot-rate']),
                'lot-step' => (int)($submittedData['lot-step']),
                'lot-date' => (trim($submittedData['lot-date'])),
            ];

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

