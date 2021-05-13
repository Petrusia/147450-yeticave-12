<?php


/**
 * @param int $price
 * @return string
 */
function getPrice(int $price): string
{
    if ($price > 0 && $price < 1000) {
        return $price . ' ₽';
    }
    if ($price >= 1000) {
        return number_format($price, 0, '', ' ') . ' ₽';
    }
}

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

    if ($period <= 86400) {
        return $errMessage;
    }
    return null;
}

/**
 * @param $field
 * @param $errMessage
 * @return string|null
 */
function validateImage($field, $errMessage): ?string
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

/**
 * @return array
 */
function getErrors(): array
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
