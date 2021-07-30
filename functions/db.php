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
 * @param string $lotId
 * @return null|array
 */
function getLot(mysqli $db, String $lotId): ?array
{
    $sql = "SELECT * FROM lot
        INNER JOIN category ON category_id = category.id
        WHERE lot.id = ?";
        return dbFetchAssoc($db, $sql, $lotId);
}


/**
 * @param mysqli $db
 * @param array $submittedData
 * @param array $authUser
 * @return int|string
 */
function saveLotData(mysqli $db, array $submittedData, array $authUser): int|string
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
        $submittedData['lot-name'],
        $submittedData['lot-message'],
        $submittedData['lot-img'],
        $submittedData['lot-rate'],
        $submittedData['lot-date'],
        $submittedData['lot-step'],
        $submittedData['lot-category'],
        $authUser['id']
    );
    $stmt->execute();
    return $db->insert_id;
}


/**
 * @param mysqli $db
 * @param string $email
 * @return null|array
 */
function getUserByEmail(mysqli $db, string $email): ?array
{
    $sql = "SELECT * FROM user WHERE email = ?";
    return dbFetchAssoc($db, $sql, $email);
}

function dbFetchAssoc(mysqli $db, string $sqlQuery, string $where): ?array
{
    $stmt = $db->prepare($sqlQuery); // подготавливаем запрос, получаем stmt
    $stmt->bind_param("s", $where); //
    $stmt->execute(); // выполняем запрос
    $result = $stmt->get_result(); // получаем result
    return $result->fetch_assoc();
}

/**
 * @param mysqli $db
 * @param $submittedData
 */
function saveUser(mysqli $db, $submittedData)
{
    $sql = "INSERT INTO user (
                 reg_date,
                  email,
                 username,
                 password,
                 contact_info
                 )  VALUES (NOW(),?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param( 'ssss',
                           $submittedData['user-email'],
                           $submittedData['user-name'],
                           $submittedData['user-password'],
                           $submittedData['user-message']
    );
    $stmt->execute();
}
