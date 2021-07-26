<?php


const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php
const ONE_MB = 1048576;
const FILE_SIZE = 1 * ONE_MB; //
const LOT_NAME_LENGTH = 50;
const ALLOWED_IMG_EXT = ['jpeg', 'jpg', 'png'];

const LOT_NAME_EXIST_ERR = 'Введите наименование лота.';
const LOT_NAME_LENGTH_ERR = 'Название не длиннее ' . LOT_NAME_LENGTH . ' символов.';
const LOT_CATEGORY_ERR = 'Выберите категорию.';
const LOT_MESSAGE_ERR = 'Введите описание лота.';
const LOT_RATE_ERR = 'Введите начальную цену.';
const LOT_STEP_ERR = 'Введите шаг ставки.';
const LOT_DATE_EXIST_ERR = 'Введите дату завершения торгов.';
const LOT_DATE_TIME_ERR = 'Введите дату больше текущей хотя бы на 1 день.';
const LOT_IMG_EXIST_ERR = 'Добавьте изображение лота.';
const LOT_IMG_EXT_ERR = 'Добавьте изображение лота в формате jpeg, jpg или png.';
const LOT_IMG_SIZE_ERR = 'Размер файла не больше ' . FILE_SIZE/ONE_MB . ' мб.';
