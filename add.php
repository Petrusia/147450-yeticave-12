<?php

require __DIR__ . '/initialize.php';

$title = 'Добавление лота';

if (!$authUser) {
    httpError($categories, 403);
}

$normalizedData = [];
$formErrors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submittedData = $_POST;
    $submittedFile = $_FILES;
    $formErrors = [];

    // этап 1: привести в порядок  данные запроса:
    $normalizedData = [
        'lot-name' => isset($submittedData['lot-name']) ? (string)$submittedData['lot-name'] : '',
        'lot-category' => isset($submittedData['lot-category']) ? (int)$submittedData['lot-category'] : '',
        'lot-message' => isset($submittedData['lot-message']) ? (string)$submittedData['lot-message'] : '',
        'lot-rate' => isset($submittedData['lot-rate']) ? (int)$submittedData['lot-rate'] : 0,
        'lot-step' => isset($submittedData['lot-step']) ? (int)$submittedData['lot-step'] : 0,
        'lot-date' => isset($submittedData['lot-date']) ? (string)$submittedData['lot-date'] : ''
    ];
    if (isset($submittedFile['lot-img']['error']) && $submittedFile['lot-img']['error'] === UPLOAD_ERR_OK) {
        $normalizedData['lot-img'] = $submittedFile['lot-img']['tmp_name'];
    }

    // этап 2: проверить  нормализованные данные
    if ($normalizedData['lot-name'] === '') {
        $formErrors['lot-name'] = 'Введите наименование лота.';
    }
    if ($normalizedData['lot-category'] <= 0) {
        $formErrors['lot-category'] = 'Выберите категорию.';
    }
    if ($normalizedData['lot-message'] === '') {
        $formErrors['lot-message'] = 'Введите наименование лота.';
    }
    if ($normalizedData['lot-rate'] <= 0) {
        $formErrors['lot-rate'] = 'Введите начальную цену.';
    }
    if ($normalizedData['lot-step'] <= 0) {
        $formErrors['lot-step'] = 'Введите шаг ставки.';
    }
    if ($normalizedData['lot-date'] === '') {
        $formErrors['lot-date'] = 'Введите дату завершения торгов.';
    } elseif ((strtotime($normalizedData['lot-date']) - time()) <= SECONDS_IN_DAY) {
        $formErrors['lot-date'] = 'Введите дату больше текущей хотя бы на 1 день.';
    }

    if (!isset($normalizedData['lot-img'])) {
        $formErrors['lot-img'] = 'Добавьте изображение лота.';
    } elseif (is_uploaded_file($normalizedData['lot-img'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($normalizedData['lot-img']);
        if (($mimeType !== 'image/jpeg') && ($mimeType !== 'image/jpg') && ($mimeType !== 'image/png')) {
            $formErrors['lot-img'] = 'Добавьте изображение лота в формате jpeg, jpg или png';
        }
    }

    // этап 3: сохранить проверенные данные если соответствует правилам валидации

    if (count($formErrors) === 0) {
        if (is_uploaded_file($normalizedData['lot-img'])) {
            $fileName = $_FILES['lot-img']['name'];
            $tempFileName = $_FILES['lot-img']['tmp_name'];
            //если использую  PROJECT_ROOT показывает путь на  Доккер сервере
            // а не путь  файла на моем компьютере /var/www/html/uploads/
            $picturePath = './uploads/' . $fileName;//
            move_uploaded_file($tempFileName, $picturePath);
            $normalizedData['lot-img'] = $picturePath;
        }


        $sql = "INSERT INTO lot (
                 lot_name,
                 lot_desc,
                 lot_img,
                 lot_price,
                 lot_end,
                 bet_step,
                 category_id,
                 author_id,
                 lot_create
                 )  VALUES (?,?,?,?,?,?,?,?,NOW())";

        $stmt = $db->prepare($sql);
        $stmt->bind_param(
            'ssssssss',
            $normalizedData['lot-name'],
            $normalizedData['lot-message'],
            $normalizedData['lot-img'],
            $normalizedData['lot-rate'],
            $normalizedData['lot-date'],
            $normalizedData['lot-step'],
            $normalizedData['lot-category'],
            $authUser['id']
        );
        $stmt->execute();

        $id = $db->insert_id;
        header("Location:  lot.php?lot_id={$id}");
        exit;
    }
}

echo renderTemplate(
    'add-template.php', $title, $authUser, $categories,
    [
        'categories' => $categories,
        'formErrors' => $formErrors,
        'lotInput' => $normalizedData
    ]
);

