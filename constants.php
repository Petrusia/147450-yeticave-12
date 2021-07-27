<?php


const SECONDS_IN_DAY = 86400; // Используема в  function validateDate() путь  functions/validation.php
const ONE_MB = 1048576;
const LOT_NAME_MIN_LENGTH = 5;
const LOT_NAME_MAX_LENGTH = 50;
const LOT_RATE_MIN_VALUE = 1000;
const LOT_RATE_MAX_VALUE = 100000;
const LOT_STEP_MIN_VALUE = 100;
const LOT_STEP_MAX_VALUE = 10000;
const LOT_MESSAGE_MIN_LENGTH = 50;
const LOT_MESSAGE_MAX_LENGTH = 5000;
const LOT_SHORTEST_TIME = SECONDS_IN_DAY;
const LOT_LONGEST_TIME = 5 * SECONDS_IN_DAY;
const LOT_IMG_SIZE = 1 * ONE_MB; //
const LOT_ALLOWED_IMG_EXT = ['jpeg', 'jpg', 'png'];

const LOT_NAME_EXIST_ERR = 'Введите наименование лота.';
const LOT_NAME_MIN_LENGTH_ERR = 'Название должно быть не меньше, чем  ' . LOT_NAME_MIN_LENGTH . ' символов.';
const LOT_NAME_MAX_LENGTH_ERR = 'Название должно быть не больше, чем ' . LOT_NAME_MAX_LENGTH . ' символов.';
const LOT_CATEGORY_ERR = 'Выберите категорию.';
const LOT_MESSAGE_ERR = 'Введите описание лота.';
const LOT_MESSAGE_MIN_LENGTH_ERR = 'Описание должно быть не меньше, чем  ' . LOT_MESSAGE_MIN_LENGTH . ' символов.';
const LOT_MESSAGE_MAX_LENGTH_ERR = 'Описание должно быть не больше, чем ' . LOT_MESSAGE_MAX_LENGTH . ' символов.';

const LOT_RATE_ERR = 'Введите начальную цену.';
const LOT_RATE_MIN_LENGTH_ERR = 'Ставка  должна быть не меньше  ' . LOT_RATE_MIN_VALUE . ' ₽';
const LOT_RATE_MAX_LENGTH_ERR = 'Ставка  должна быть не больше ' . LOT_RATE_MAX_VALUE . ' ₽';
const LOT_STEP_ERR = 'Введите шаг ставки.';
const LOT_STEP_MIN_LENGTH_ERR = 'Шаг ставки должен быть не меньше  ' . LOT_STEP_MIN_VALUE . ' ₽';
const LOT_STEP_MAX_LENGTH_ERR = 'Шаг ставки должен быть не больше ' . LOT_STEP_MAX_VALUE . ' ₽';
const LOT_DATE_EXIST_ERR = 'Введите дату завершения торгов.';
const LOT_SHORTEST_TIME_ERR = 'Дата должна быть не меньше, чем ';
const LOT_LONGEST_TIME_ERR = 'Дата должна быть не более, чем ';
const LOT_IMG_EXIST_ERR = 'Добавьте изображение лота.';
const LOT_IMG_EXTENTION_ERR = 'Добавьте изображение лота в формате jpeg, jpg или png.';
const LOT_IMG_SIZE_ERR = 'Размер файла должен быть не больше ' . LOT_IMG_SIZE/ONE_MB . ' мб.';
