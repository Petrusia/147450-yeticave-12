<?php

/**
 * @param string $string
 * @param string $emptyErrText
 * @param bool $required
 * @param int|null $min
 * @param string $minErrText
 * @param int|null $max
 * @param string $maxErrText
 * @return string|null
 */
function validateText(
    string $string,
    string $emptyErrText,
    bool $required = true,
    ?int $min = null,
    string $minErrText = '',
    ?int $max = null,
    string $maxErrText = '',
): ?string {
    $length = mb_strlen($string);
    if ($required && $length === 0) {
        return $emptyErrText;
    } elseif ($min !== null && $length < $min) {
        return $minErrText;
    } elseif ($max !== null && $length > $max) {
        return $maxErrText;
    }
    return null;
}


/**
 * @param string $number
 * @param string $emptyErrText
 * @param bool $required
 * @param int|null $min
 * @param string $minErrText
 * @param int|null $max
 * @param string $maxErrText
 * @return string|null
 */
function validateNumber(
    string $number,
    string $formatErrText,
    string $emptyErrText,
    bool $required = true,
    ?int $min = null,
    string $minErrText = '',
    ?int $max = null,
    string $maxErrText = ''
): ?string {
    $length = mb_strlen($number);

    if (!is_numeric($number)) {
        return $formatErrText;
    } elseif ($required && $length === 0) {
        return $emptyErrText;
    } elseif ($min !== null && $number < $min) {
        return $minErrText;
    } elseif ($max !== null && $number > $max) {
        return $maxErrText;
    }
    return null;
}


/**
 * @param string $id
 * @param array $categories
 * @param string $emptyErrText
 * @return string|null
 */
function validateCategory(
    string $id,
    array $categories,
    string $emptyErrText,
): ?string
{
    $length = mb_strlen($id);
    $allCatId = array_column($categories, 'id');
    if ($length === 0 && !is_numeric($id) && !in_array($id, $allCatId)) {
            return $emptyErrText;
        }
    return null;
}

    /**
     * @param string $date
     * @param string $emptyErrText
     * @param string $invalidDateErr
     * @param bool $required
     * @param string $format
     * @param int|null $min
     * @param string $minErrText
     * @param int|null $max
     * @param string $maxErrText
     * @return string|null
     */
    function validateDate(
        string $date,
        string $emptyErrText,
        string $invalidDateErr,
        bool $required = true,
        string $format = 'Y-m-d',
        ?int $min = null,
        string $minErrText = '',
        ?int $max = null,
        string $maxErrText = '',
    ): ?string {
        if ($required && $date === '') {
            return $emptyErrText;
        }

        if (date_create_from_format($format, $date) == false) {
            return $invalidDateErr;
        }
        $timestamp = strtotime($date);

        if ($min !== null && $timestamp < $min) {
            return $minErrText . date("Y-m-d H:i:s", $min);
        }
        if ($max && $timestamp > $max) {
            return $maxErrText . date("Y-m-d H:i:s", $max);
        }
        return null;
    }

    /**
     * @param array $submittedFile
     * @param string $emptyErrText
     * @param string $extErrText
     * @param string $sizeErrText
     * @return string|null
     */
    function validateImage(array $submittedFile, string $emptyErrText, string $extErrText, string $sizeErrText): ?string
    {
        $ext = pathinfo($submittedFile['lot-img']['name'], PATHINFO_EXTENSION);
        if (isset($submittedFile['lot-img']['error']) && $submittedFile['lot-img']['error'] === UPLOAD_ERR_NO_FILE) {
            return $emptyErrText;
        } elseif (!in_array($ext, LOT_ALLOWED_IMG_EXT)) {
            return $extErrText;
        } elseif ($submittedFile['lot-img']['size'] > LOT_IMG_SIZE) {
            return $sizeErrText;
        }
        return null;
    }


    function isUserEmailExists (string $email, mysqli $db, string $emailExistErrText): ?string
    {
        $user = getUserByEmail($db, $email);

        If ($user !== null) {
            return $emailExistErrText;
        }
        return null;
    };

    function validateEmail(
        string $email,
        string $emptyErrText,
        string $emailFormatErrText,
        bool $required = true,
    ): ?string
    {
        $length = mb_strlen($email);
        $email = filter_var( $email, FILTER_VALIDATE_EMAIL);

        if ($length > 0 && $email === false) {
            return $emailFormatErrText;
        } elseif ($required) {
            return  $emptyErrText;
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



    function getRegisterErrors(mysqli $db): array
    {
        $errors = [
            'user-email' => validateEmail(
                $db,
                'user-email',
                'Введите e-mail',
                'Пользователь с этим email уже зарегистрирован'
            ),
            'user-password' => validatePassword('Введите пароль'),
            'user-name' => validateString('user-name', 'Введите имя'),
            'user-message' => validateString('user-message', 'Напишите как с вами связаться')
        ];
        return array_filter($errors);
    }


    function verifyEmail(mysqli $db, string $email, string $errMessage, string $errEmail): ?string
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

    function verifyPassword(mysqli $db, string $errMessage, string $errPassword): ?string
    {
        if (empty($_POST['user-password'])) {
            return $errMessage;
        }

        $password = (getPassword($db, $_POST['user-email']));

        if (password_verify($_POST['user-password'], $password['password'])) {
            return null;
        } else {
            return $errPassword;
        }
    }

    function getLoginErrors(mysqli $db): array
    {
        $errors = [
            'user-email' => verifyEmail(
                $db,
                'user-email',
                'Введите e-mail',
                'Пользователь с этим email не зарегистрирован'
            ),
            'user-password' => verifyPassword($db, 'Введите пароль', 'Вы ввели неверный пароль')
        ];
        return array_filter($errors);
    }

// для залогиненных пользователей надо закрыть страницу регистрации.
    function httpError(array $categories, int $responseCode, string $errMessage = null)
    {
        $error = [
            403 => $errMessage ?? '403 - У вас нет права зайти на страницу ',
            404 => '404 - Данной страницы не существует на сайте',
        ];

        $title = $error[$responseCode];

        http_response_code($responseCode);
        echo renderTemplate('404-template.php', $title, $authUser = false, $categories,
            [
                'categories' => $categories,
                'message' => $title
            ]
        );
        exit;

}
