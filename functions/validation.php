<?php

// Считайте, что содержимое главной страницы (список категорий и объявлений)
// получено от пользователя,
// поэтому его нужно соответствующим образом фильтровать для защиты от XSS.
/**
 * @param string $string содержимое
 * @return string фильтровать для защиты от XSS
 */
function h( $string)
{
    return htmlspecialchars($string);
}

/**
 * добавляет к цене ' ₽', в случае стоимости от 1000 устанавливает разделитель тысяч
 * @param $price int цена товара, введенная пользователем
 * @return string цена товара для объявления
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

function validateString(string $field, string $errMessage): string
{
    $field = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
    if ($field) {
        return '';
    }
    return $errMessage;
}

function validateInt(string $field, string $errMessage): string
{
    $field = filter_input(INPUT_POST, $field,  FILTER_VALIDATE_INT);
    if ($field && $field > 0 ) {
        return '';
    }
    return  $errMessage;
}

function validateFloat(string $field, string $errMessage): string
{
    $field = filter_input(INPUT_POST, $field,  FILTER_VALIDATE_FLOAT);
    if ($field && $field > 0 ) {
        return '';
    }
    return $errMessage;
}
function validateDate(string $field, string $errMessage): string
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
    return '';
}

function validateImage($field, $errMessage)
{
    if ($_FILES[$field]['error'] > 0 ) {
        return $errMessage;
    }
    $mimetype = mime_content_type($_FILES[$field]['tmp_name']);
    if (!(in_array($mimetype, ['image/jpeg', 'image/png']))) {
        return $errMessage;
    }
    return '';
}

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
