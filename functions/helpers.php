<?php

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template(string $name, array $data = []): string
{
    $name = PROJECT_ROOT . '/templates/' . $name;
    ob_start();
    extract($data);
    require $name;
    return ob_get_clean();
}


/**
 * @param string $expire_at
 * @return array
 */
function getDateDiff(string $expire_at): array
{
    $period = strtotime($expire_at) - time();
    $hours = floor($period / 3600);
    $minutes = 60 - date('i');

    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [
        'hours' => $hours,
        'minutes' => $minutes
    ];
}


/**
 * @param int $price
 * @return string
 */
function getPrice(int $price): string
{
    $price = ceil($price);
    return number_format($price, 0, '', ' ') . ' ₽';
}




/**
 * Преобразует специальные символы в HTML-сущности
 * @param string $str
 * @return string
 */
function esc(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}


/**
 * @param string $name
 * @param array $data
 * @return string
 */
function  renderTemplate(string $name, string $title, array|string $authUser, array $categories,  array $data = [], bool $isIndex = false): string
{
    $main = include_template($name, $data);
    return include_template('layout-template.php', [
        'title' => $title,
        'isIndex' => $isIndex,
        'authUser' => $authUser,
        'categories' => $categories,
        'main' => $main,
    ]);
}

function normalizedLotData(array $submittedData) : array
{

    $normalizedData = [
        // trim возвращает строку string с удалёнными из начала и конца строки пробелами.
        'lot-name' => trim($submittedData['lot-name']),
        'lot-category' => (int)($submittedData['lot-category']),
        'lot-message' => (trim($submittedData['lot-message'])),
        'lot-rate' => (int)($submittedData['lot-rate']),
        'lot-step' => (int)($submittedData['lot-step']),
        'lot-date' => (trim($submittedData['lot-date'])),
    ];

    return $normalizedData;
}

function validatedText(string $string,  string $emptyErr, int $length = null, string $emptyLengthErr = null): ?string
{
    $errorText = null;
    if (empty($string)) {
        $errorText = $emptyErr;
    } elseif ($length && strlen($string) >= $length) {
        $errorText = $emptyLengthErr;
    }
    return $errorText;
}
function validatedInt( string $number, string $emptyErr) :?string {
    $errorText = null;
    if(empty($$number) && $number <= 0 ) {
        $errorText = $emptyErr;
    }
    return $errorText;
}


function validatedCategory(string $lotCategory, array $categories, string $categoryErr): ?string
{
    $errorText = null;
    $allLotCat = array_column($categories, 'id');
    if(!is_int($lotCategory) && !in_array($lotCategory, $allLotCat)) {
        $errorText = $categoryErr;
    }
    return $errorText;
}

function validatedDate(string $date, string $emptyErr, string $timeErr): ?string
{
    $errorText = null;
    if (empty($date)) {
        $errorText = $emptyErr;
    } elseif ((strtotime($date) - time()) <= SECONDS_IN_DAY) {
        $errorText = $timeErr;
    }
    return $errorText;
}

function validatedImage(array $submittedFile, string $emptyErr, string $extErr, string $sizeErr): ?string
{
    $errorText = null;
    $ext = pathinfo($submittedFile['lot-img']['name'], PATHINFO_EXTENSION);
    if (isset($submittedFile['lot-img']['error']) && $submittedFile['lot-img']['error'] === UPLOAD_ERR_NO_FILE) {
        $errorText = $emptyErr;
    } elseif (!in_array($ext, ALLOWED_IMG_EXT)) {
        $errorText =  $extErr;
    } elseif ($submittedFile['lot-img']['size'] > FILE_SIZE)  {
        $errorText =  $sizeErr;
    }
    return $errorText;
}

function validatedLotData(array $submittedData, array $submittedFile, array $categories) : array
{
    $formErrors = [];

    $formErrors['lot-name'] = validatedText($submittedData['lot-name'], LOT_NAME_EXIST_ERR, LOT_NAME_LENGTH, LOT_NAME_LENGTH_ERR);
    $formErrors['lot-category'] = validatedCategory($submittedData['lot-category'], $categories, LOT_CATEGORY_ERR);
    $formErrors['lot-message'] = validatedText($submittedData['lot-message'], LOT_MESSAGE_ERR);
    $formErrors['lot-rate'] = validatedInt( $submittedData['lot-rate'],  LOT_RATE_ERR);
    $formErrors['lot-step'] = validatedInt( $submittedData['lot-step'],  LOT_STEP_ERR);
    $formErrors['lot-date'] = validatedDate( $submittedData['lot-date'],  LOT_DATE_EXIST_ERR, LOT_DATE_TIME_ERR);
    $formErrors['lot-img'] = validatedImage( $submittedFile,  LOT_IMG_EXIST_ERR, LOT_IMG_EXT_ERR, LOT_IMG_SIZE_ERR);

    return array_filter($formErrors);
}

function randomString($length): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), 0, $length);
}

function imageUpload(array $submittedFile,array $submittedData) : array
{
    if (is_uploaded_file($submittedFile['lot-img']['tmp_name'])) {
        $fileName = $submittedFile['lot-img']['name'];
        $tempFileName = $submittedFile['lot-img']['tmp_name'];
        $fileName = randomString(10) .'-'. $fileName;
        $picturePath = './uploads/' . $fileName;//
        move_uploaded_file($tempFileName, $picturePath);
        $submittedData['lot-img'] = $picturePath;
    }
    return $submittedData;
}
