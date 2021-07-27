<?php

/**
 * @param string $string
 * @param string $emptyErr
 * @param int $minLength
 * @param string $minLengthErr
 * @param int $maxLength
 * @param string $maxLengthErr
 * @return string|null
 */
function validateText(
    string $string,
    string $emptyErr,
    int $minLength = 0,
    string $minLengthErr = '',
    int $maxLength = 0,
    string $maxLengthErr = ''
): ?string {
    $errorText = null;
    $length = mb_strlen($string);
    if (empty($string)) {
        $errorText = $emptyErr;
    } elseif ($minLength && $length <= $minLength) {
        $errorText = $minLengthErr;
    } elseif ($maxLength && $length >= $maxLength) {
        $errorText = $maxLengthErr;
    }
    return $errorText;
}


/**
 * @param string $number
 * @param string $emptyErr
 * @param int $minValue
 * @param string $minLengthErr
 * @param int $maxValue
 * @param string $maxLengthErr
 * @return string|null
 */
function validatedNumber(
    string $number,
    string $emptyErr,
    int $minValue = 0,
    string $minLengthErr = '',
    int $maxValue = 0,
    string $maxLengthErr = ''
): ?string {
    $errorText = null;
    if (empty($number)) {
        $errorText = $emptyErr;
    } elseif ($minValue && $number < $minValue) {
        $errorText = $minLengthErr;
    } elseif ($maxValue && $number > $maxValue) {
        $errorText = $maxLengthErr;
    }
    return $errorText;
}


/**
 * @param string $lotCategory
 * @param array $categories
 * @param string $categoryErr
 * @return string|null
 */
function validateCategory(string $lotCategory, array $categories, string $categoryErr): ?string
{
    $errorText = null;
    $allLotCat = array_column($categories, 'id');
    if(!is_int($lotCategory) && !in_array($lotCategory, $allLotCat)) {
        $errorText = $categoryErr;
    }
    return $errorText;
}


/**
 * @param string $date
 * @param string $emptyErr
 * @param int $shortestTime
 * @param string $shortestTimeErr
 * @param int $longestTime
 * @param string $longestTimeErr
 * @return string|null
 */
function validateDate(
    string $date,
    string $emptyErr,
    int $shortestTime = 0,
    string $shortestTimeErr = '',
    int $longestTime = 0,
    string $longestTimeErr = '',
): ?string
{
    $errorText = null;

    $min = date("Y-m-d H:i:s", time() + $shortestTime);
    $max = date("Y-m-d H:i:s", time() + $longestTime);
    if (empty($date)) {
        $errorText = $emptyErr;
    } elseif ( $shortestTime && $date <= $min) {
        $errorText = $shortestTimeErr .  $min;
    }elseif ( $longestTime && $date >= $max) {
        $errorText = $longestTimeErr . $max;
    }
    return $errorText;
}

/**
 * @param array $submittedFile
 * @param string $emptyErr
 * @param string $extErr
 * @param string $sizeErr
 * @return string|null
 */
function validateImage(array $submittedFile, string $emptyErr, string $extErr, string $sizeErr): ?string
{
    $errorText = null;
    $ext = pathinfo($submittedFile['lot-img']['name'], PATHINFO_EXTENSION);
    if (isset($submittedFile['lot-img']['error']) && $submittedFile['lot-img']['error'] === UPLOAD_ERR_NO_FILE) {
        $errorText = $emptyErr;
    } elseif (!in_array($ext, LOT_ALLOWED_IMG_EXT)) {
        $errorText =  $extErr;
    } elseif ($submittedFile['lot-img']['size'] > LOT_IMG_SIZE)  {
        $errorText =  $sizeErr;
    }
    return $errorText;
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
    403 => '403 - У вас нет права зайти на страницу ',
    404 => '404 - Данной страницы не существует на сайте'
    ];

    $title =  $error[$responseCode];

    http_response_code($responseCode);
    echo renderTemplate('404-template.php', $title, $authUser = false, $categories, [
            'categories' => $categories,
            'message' => $title
        ]);
        exit;
}
