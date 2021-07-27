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
