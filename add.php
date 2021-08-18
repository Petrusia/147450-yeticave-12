<?php

require __DIR__ . '/initialize.php';

$title = 'Добавление лота';

if (!$authUser) {
    httpError($categories, $authUser,403);
}

$formErrors = [];
$submittedData = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_SESSION['token'] !== $_POST['token']) {
        httpError($categories, $authUser, 403);
    }


    $submittedFile = $_FILES;
    // этап 1: принять все данные формы:
    $submittedData = [
        'lot-name' => trim(filter_input(INPUT_POST, 'lot-name')),
        'lot-category' => trim(filter_input(INPUT_POST, 'lot-category')),
        'lot-message' =>trim(filter_input(INPUT_POST, 'lot-message')),
        'lot-rate' => trim(filter_input(INPUT_POST, 'lot-rate')),
        'lot-step' => trim(filter_input(INPUT_POST, 'lot-step')),
        'lot-date' => trim(filter_input(INPUT_POST, 'lot-date')),
    ];

    // этап 2: проверить данные запроса:
    $formErrors = [
        'lot-name' => validateText(
            $submittedData['lot-name'],
            LOT_NAME_EXIST_ERR,
            LOT_NAME_REQUIRED,
            LOT_NAME_MIN_LENGTH,
            LOT_NAME_MIN_LENGTH_ERR,
            LOT_NAME_MAX_LENGTH,
            LOT_NAME_MAX_LENGTH_ERR
        ),
        'lot-category' => validateCategory(
            $submittedData['lot-category'],
            $categories,
            LOT_CATEGORY_ERR
        ),
        'lot-message' => validateText(
            $submittedData['lot-message'],
            LOT_MESSAGE_ERR,
            LOT_CATEGORY_REQUIRED,
            LOT_MESSAGE_MIN_LENGTH,
            LOT_MESSAGE_MIN_LENGTH_ERR,
            LOT_MESSAGE_MAX_LENGTH,
            LOT_MESSAGE_MAX_LENGTH_ERR
        ),
        'lot-rate' => validateNumber(
            $submittedData['lot-rate'],
            NUMBER_ERR,
            LOT_RATE_ERR,
            LOT_RATE_REQUIRED,
            LOT_RATE_MIN_VALUE,
            LOT_RATE_MIN_LENGTH_ERR,
            LOT_RATE_MAX_VALUE,
            LOT_RATE_MAX_LENGTH_ERR
        ),
        'lot-step' => validateNumber(
            $submittedData['lot-step'],
            NUMBER_ERR,
            LOT_STEP_ERR,
            LOT_STEP_REQUIRED,
            LOT_STEP_MIN_VALUE,
            LOT_STEP_MIN_LENGTH_ERR,
            LOT_STEP_MAX_VALUE,
            LOT_STEP_MAX_LENGTH_ERR
        ),

        'lot-date' => validateDate(
            $submittedData['lot-date'],
            LOT_DATE_EXIST_ERR,
            LOT_DATE_FORMAT_ERR,
            LOT_DATE_REQUIRED,
            LOT_DATE_FORMAT,
            time() + LOT_MIN_TIME,
            LOT_MIN_TIME_ERR,
            time() + LOT_MAX_TIME,
            LOT_MAX_TIME_ERR,
        ),
        'lot-img' => validateImage($submittedFile, LOT_IMG_EXIST_ERR, LOT_IMG_EXTENSION_ERR, LOT_IMG_SIZE_ERR),
    ];
    $formErrors=array_filter($formErrors);

    // этап 3: сохранить проверенные данные если соответствует правилам валидации:
    if (count($formErrors) === 0) {
        $submittedData['lot-img']  = uploadFile($submittedFile['lot-img'], IMAGE_PATH);
        $id = saveLotData($db, $submittedData, $authUser);
        header("Location: /lot.php?lot_id={$id}");
        exit;
    }
}

echo renderTemplate(
    'add-template.php', $title, $authUser, $categories, [
        'categories' => $categories,
        'formErrors' => $formErrors,
        'submittedData' =>  $submittedData,
    ]
);


