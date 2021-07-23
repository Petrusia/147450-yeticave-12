<?php

use JetBrains\PhpStorm\NoReturn;


/**
 * @param string $field
 * @param string $errMessage
 * @return string|null
 */
function validateString(string $field, string $errMessage): ?string
{
    $field = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
    if ($field) {
        return null;
    }
    return $errMessage;
}

/**
 * @param string $field
 * @param string $errMessage
 * @return string|null
 */
function validateInt(string $field, string $errMessage): ?string
{
    $field = filter_input(INPUT_POST, $field,  FILTER_VALIDATE_INT);
    if ($field && $field > 0 ) {
        return null;
    }
    return  $errMessage;
}

/**
 * @param string $field
 * @param string $errMessage
 * @return string|null
 */
function validateFloat(string $field, string $errMessage): ?string
{
    $field = filter_input(INPUT_POST, $field,  FILTER_VALIDATE_FLOAT);
    if ($field && $field > 0 ) {
        return null;
    }
    return $errMessage;
}

/**
 * @param string $field
 * @param string $errMessage
 * @return string|null
 */
function validateDate(string $field, string $errMessage): ?string
{
    $field = $_POST[$field];
    if (empty( $field)) {
        return $errMessage;
    }

    $currentDate = time();
    $endDate = strtotime($field);
    $period = $endDate - $currentDate;

    if ($period <= SECONDS_IN_DAY) {
        return $errMessage;
    }
    return null;
}


/**
 * @param string $field
 * @param string $errMessage
 * @return string|null
 */
function validateImage(string $field, string $errMessage): ?string
{
    if ($_FILES[$field]['error'] > 0 ) {
        return $errMessage;
    }
    $mimetype = mime_content_type($_FILES[$field]['tmp_name']);
    if (!(in_array($mimetype, ['image/jpeg', 'image/png']))) {
        return $errMessage;
    }
    return null;
}

function validateEmail( mysqli $db, string $field, string $errMessage, string $errEmail): ?string
{
    $field = filter_input(INPUT_POST, $field,  FILTER_VALIDATE_EMAIL);
    if (empty($field)) {
        return $errMessage;
    }
    if (isEmailExist($db, $field)) {
        return $errEmail;
    }
    return null;
}

function validatePassword(string $errMessage): ?string
{
    if (empty($_POST['user-password'])) {
        return $errMessage;
    }
    return null;
}

/**
 * @return array
 */
function getLotErrors(): array
{
        $errors = [
            'lot-name' => validateString('lot-name', 'Введите наименование лота'),
            'lot-category' => validateInt('lot-category', 'Выберите категорию'),
            'lot-message' => validateString('lot-message', 'Напишите описание лота'),
            'lot-rate' => validateFloat('lot-rate', 'Введите начальную цену'),
            'lot-step' => validateInt('lot-step', 'Введите шаг ставки'),
            'lot-date' => validateDate('lot-date', 'Введите дату завершения торгов'),
            'lot-img' => validateImage('lot-img', 'Добавьте изображение лота')
        ];
        return array_filter($errors);
}

function getRegisterErrors(mysqli $db ): array
{
    $errors = [
        'user-email' => validateEmail($db, 'user-email', 'Введите e-mail', 'Пользователь с этим email уже зарегистрирован'),
        'user-password' => validatePassword( 'Введите пароль'),
        'user-name' => validateString('user-name', 'Введите имя'),
        'user-message' => validateString('user-message', 'Напишите как с вами связаться')
    ];
    return array_filter($errors);
}


function verifyEmail( mysqli $db, string $email, string $errMessage, string $errEmail): ?string
{
    $email = filter_input(INPUT_POST, $email, FILTER_VALIDATE_EMAIL);
    if (empty($email)) {
        return $errMessage;
    }
    if (isEmailExist($db, $email)) {
        return null;
    } else {
    return $errEmail;
    }
}

function verifyPassword(mysqli $db, string $errMessage, string $errPassword ): ?string
{
    if (empty($_POST['user-password'])) {
        return $errMessage;
    }

    $password = (getPassword($db, $_POST['user-email']));

    if (password_verify($_POST['user-password'], $password['password'])){
        return null;
    }  else {
        return $errPassword;
    }
}

function getLoginErrors(mysqli $db): array
{
    $errors = [
        'user-email' => verifyEmail($db, 'user-email', 'Введите e-mail', 'Пользователь с этим email не зарегистрирован'),
        'user-password' => verifyPassword($db, 'Введите пароль', 'Вы ввели неверный пароль')
       ];
    return array_filter($errors);
}

// для залогиненных пользователей надо закрыть страницу регистрации.
function httpError( array $categories, int $responseCode)
{
    $error = [
    403 => '403 - У вас нет права зайти на страницу',
    404 => '404 - Данной страницы не существует на сайте'
    ];

    $title =  $error[$responseCode];

    http_response_code($responseCode);
    echo renderTemplate('404-template.php', $title, $userName = false, $categories, [
            'categories' => $categories,
            'message' => $title
        ]);
        exit;
}
