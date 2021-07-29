<?php
declare(strict_types=1);
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
        $uploadFileError = isset($submittedFile['lot-img']['error']) && $submittedFile['lot-img']['error'] === UPLOAD_ERR_NO_FILE;
        $notAllowedFileExtension = !in_array($ext, LOT_ALLOWED_IMG_EXT);
        $notAllowedFileSize = $submittedFile['lot-img']['size'] > LOT_IMG_SIZE;

        if ($uploadFileError) {
            return $emptyErrText;
        } elseif ($notAllowedFileExtension) {
            return $extErrText;
        } elseif ($notAllowedFileSize) {
            return $sizeErrText;
        }
        return null;
    }


function isUserEmailExists(
    string $email,
    mysqli $db,
    string $emailExistErrText = '',
    string $emailNoExistErrText = ''
): ?string {
    $user = getUserByEmail($db, $email);

    if ($user !== null) {
        return $emailExistErrText;
    }
    if ($user == null) {
        return $emailNoExistErrText;
    }
    return null;
}

function isUserPasswordExists (
    string $email,
    string $password,
    mysqli $db,
    string $PasswordNoExistErrText): ?string
{
    $user = getUserByEmail($db, $email);
    $passwordNoExist = !password_verify($password, $user['password']);

    if ($passwordNoExist) {
        return $PasswordNoExistErrText;
    }
    return null;
}

    function validateEmail(
        string $email,
        string $emptyErrText,
        string $emailFormatErrText,
        bool $required = true,
    ): ?string
    {
        $emptyEmail = mb_strlen($email) === 0;
        $invalidEmail = filter_var( $email, FILTER_VALIDATE_EMAIL) === false;
        if ($required && $emptyEmail) {
            return  $emptyErrText;
        }
        if ($required && $invalidEmail) {
            return $emailFormatErrText;
        }
        return null;
    }


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
