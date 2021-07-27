<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * @param mysqli $db
 * @return array
 */
function getCategories(mysqli $db): array
{
    $sqlQuery = "SELECT * FROM category";
    $result = $db->query( $sqlQuery);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param mysqli $db
 * @return array
 */
function getLots(mysqli $db): array
{
    $sqlQuery = "SELECT  lot.id, lot_name, lot_desc, lot_img, lot_price, lot_create, lot_end, bet_step,
author_id, category_id, category_name

    FROM lot
        INNER JOIN category ON category_id = category.id
        INNER JOIN user ON author_id = user.id
WHERE lot_end > NOW()
ORDER BY lot_create DESC
LIMIT 9 ";

    $result = $db->query($sqlQuery);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param mysqli $db
 * @param int $lotId
 * @return array
 */
function getLot(mysqli $db, int $lotId): array
{
    $sql = "SELECT * FROM lot
        INNER JOIN category ON category_id = category.id
        WHERE lot.id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $lotId);
    $stmt->execute();
    $result = $stmt->get_result();
    return  $result->fetch_assoc();
}


/**
 * @param mysqli $db
 * @param array $normalizedData
 * @param array $authUser
 */
#[NoReturn] function saveLotData(mysqli $db, array $normalizedData, array $authUser)
{
    $sql = "INSERT INTO lot (
                 lot_name,
                 lot_desc,
                 lot_img,
                 lot_price,
                 lot_end,
                 bet_step,
                 category_id,
                 author_id,
                 lot_create
                 )  VALUES (?,?,?,?,?,?,?,?,NOW())";

    $stmt = $db->prepare($sql);
    $stmt->bind_param(
        'ssssssss',
        $normalizedData['lot-name'],
        $normalizedData['lot-message'],
        $normalizedData['lot-img'],
        $normalizedData['lot-rate'],
        $normalizedData['lot-date'],
        $normalizedData['lot-step'],
        $normalizedData['lot-category'],
        $authUser['id']
    );
    $stmt->execute();

    $id = $db->insert_id;
    header("Location: lot.php?lot_id={$id}");
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

/**
 * @return array
 */
function getRegisterInput(): array
{
    return [
        'user-email' => $_POST['user-email'],
        'user-password' => password_hash($_POST['user-password'], PASSWORD_DEFAULT),
        'user-name' => $_POST['user-name'],
        'user-message' => $_POST['user-message']
    ];
}

/**
 * @param mysqli $db
 * @param string $email
 * @return bool
 */
function isEmailExist(mysqli $db, string $email):bool
{
    $sql = "SELECT count(id) FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_row($result);
    return $result[0];
}

/**
 * @param mysqli $db
 * @param $registerInput
 */
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

/**
 * @param mysqli $db
 * @param string $email
 * @return array|false|string[]|null
 */
function getPassword(mysqli $db, string $email)
{
    $sql = "SELECT password FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}

/**
 * @return array
 */
function getLoginInput(): array
{
    return [
        'user-email' => $_POST['user-email'],
        'user-password' => $_POST['user-password'],
    ];
}


/**
 * @param mysqli $db
 * @param string $email
 */
function setSession(mysqli $db, string $email)
{
    $sql = "SELECT id, username, email FROM user WHERE email = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);
    session_regenerate_id(true);
    $_SESSION['authUser'] = $user;
    header("Location: / ");
    exit;
}
