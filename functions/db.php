<?php

/**
 * @return mysqli
 */
function getDb(): mysqli
{
    $dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_set_charset($dbConnection, "utf8");
    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }
    return $dbConnection;
}

/**
 * @param mysqli $db
 * @return array
 */
function getCategories(mysqli $db): array
{
    $sqlQuery = "SELECT * FROM category";
    $sqlQueryResult = mysqli_query($db, $sqlQuery);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}

/**
 * @param mysqli $db
 * @return array
 */
function getLots(mysqli $db): array
{
    $sqlQuery = "SELECT  lot.id, lot_name, lot_desc, lot_img, lot_price, lot_create, lot_end, bet_step,
author_id, category_id

    FROM lot
        INNER JOIN category ON category_id = category.id
        INNER JOIN user ON author_id = user.id  ORDER BY lot_create DESC ";


    $sqlQueryResult = mysqli_query($db, $sqlQuery);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}

/**
 * @param mysqli $db
 * @param int $lotId
 * @return array|false|string[]|null
 */
function getLot(mysqli $db, int $lotId)
{
    $sql = "SELECT * FROM lot
        INNER JOIN category ON category_id = category.id
        WHERE lot.id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $lotId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}

/**
 * @param mysqli $db
 * @param $lotInput
 */
function saveLot(mysqli $db, $lotInput)
{
    $sqlQuery = "INSERT INTO lot (
                 lot_name,
                 lot_desc,
                 lot_img,
                 lot_price,
                 lot_end,
                 bet_step,
                 category_id,
                 lot_create,
                 author_id
                 )  VALUES (?,?,?,?,?,?,?,NOW(),1)";
    $stmt =  mysqli_prepare($db, $sqlQuery);
    mysqli_stmt_bind_param($stmt, 'sssdsii',
                           $lotInput['lot-name'],
                           $lotInput['lot-message'],
                            $lotInput['lot-img'],
                           $lotInput['lot-rate'],
                           $lotInput['lot-date'],
                           $lotInput['lot-step'],
                           $lotInput['lot-category']
    );
    $sqlQueryResult = mysqli_stmt_execute($stmt);
    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    $id = mysqli_insert_id($db);
    header("Location:  lot.php?lot_id={$id}");
    exit;
}


/**
 * @return array
 */
function getLotInput(): array
{
    return [
        'lot-name' => $_POST['lot-name'],
        'lot-category' => (int) $_POST['lot-category'],
        'lot-message' => $_POST['lot-message'],
        'lot-rate' => (float) $_POST['lot-rate'],
        'lot-step' => (int) $_POST['lot-step'],
        'lot-date' => $_POST['lot-date'],
        'lot-img' => ''
    ];
}

/**
 * @return string
 */
function getImage(): string
{
    $imageName = $_FILES['lot-img']['name'];
    $tempImageName = $_FILES['lot-img']['tmp_name'];
    $imageDir = PROJECT_ROOT . '/uploads/';
    $imageUrl = '/uploads/' . $imageName;
    move_uploaded_file($tempImageName, $imageDir . $imageName);
    return $imageUrl;
}

function getRegisterInput(): array
{
    return [
        'user-email' => $_POST['user-email'],
        'user-password' => password_hash($_POST['user-password'], PASSWORD_DEFAULT),
        'user-name' => $_POST['user-name'],
        'user-message' => $_POST['user-message']
    ];
}

function isEmailExist(mysqli $db, string $email):bool
{
    $sql = "SELECT count(id) FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_row($res);
    if ($res[0]) {
        return true;
    }
    return false;
}

function registerUser(mysqli $db, $registerInput)
{
    $sqlQuery = "INSERT INTO user (
                 reg_date,
                  email,
                 username,
                 password,
                 contact_info
                 )  VALUES (NOW(),?,?,?,?)";
    $stmt =  mysqli_prepare($db, $sqlQuery);
    mysqli_stmt_bind_param($stmt, 'ssss',
                           $registerInput['user-email'],
                           $registerInput['user-name'],
                           $registerInput['user-password'],
                           $registerInput['user-message']
    );
    $sqlQueryResult = mysqli_stmt_execute($stmt);
    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    $id = mysqli_insert_id($db);
    header("Location:  login.php");
    exit;
}

function getPassword(mysqli $db, string $email)
{
    $sql = "SELECT password FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}

function getLoginInput(): array
{
    return [
        'user-email' => $_POST['user-email'],
        'user-password' => $_POST['user-password'],
    ];
}



function setSession(mysqli $db, string $email)
{
    $sql = "SELECT username, email FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);
    session_regenerate_id(true);
    $_SESSION['userName'] = $user['username'];
    header("Location:  /");
    exit;
}
