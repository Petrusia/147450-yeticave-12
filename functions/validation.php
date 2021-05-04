<?php

// Считайте, что содержимое главной страницы (список категорий и объявлений)
// получено от пользователя,
// поэтому его нужно соответствующим образом фильтровать для защиты от XSS.
function h(string $string): string
{
    return htmlspecialchars($string);
}

/**
 * добавляет к цене ' ₽', в случае стоимости от 1000 устанавливает разделитель тысяч
 * @param $price int цена товара, введенная пользователем
 * @return string цена товара для объявления
 */

function get_price(int $price): string
{
    if ($price > 0 && $price < 1000) {
        return $price . ' ₽';
    }
    if ($price >= 1000) {
        return number_format($price, 0, '', ' ') . ' ₽';
    }
}

