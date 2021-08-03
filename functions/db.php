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
    $sqlQuery = "SELECT  lot.lot_id, lot_name, lot_desc, lot_img, lot_price, lot_create, lot_end, lot_bet_step,
lot_author_id, lot_category_id, category_name

     FROM lot
        INNER JOIN category ON lot_category_id = category.category_id
        INNER JOIN user ON lot_author_id = user.user_id

WHERE lot_end > NOW()
ORDER BY lot_create DESC
LIMIT 9 ";

    $result = $db->query($sqlQuery);
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getBets(mysqli $db): array
{
    $sqlQuery = "SELECT  bet.bet_id, bet_price, bet_author_id, bet_lot_id

     FROM bet
        INNER JOIN user ON bet_author_id = user.user_id
        INNER JOIN lot ON bet_lot_id = lot.lot_id

ORDER BY bet_date DESC";

    $result = $db->query($sqlQuery);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param mysqli $db
 * @param int $lotId
 * @return array
 */
function getLotById(mysqli $db, int $lotId): ?array
{
    $sql = "SELECT * FROM lot
        INNER JOIN category ON category_id = lot_category_id
        WHERE lot_id = ?";
        return dbFetchAssoc($db, $sql, $lotId);
}

function getBetsByLotId(mysqli $db, int $lotId): ?array
{
    $sql = "SELECT * FROM bet
        INNER JOIN user ON bet_author_id = user.user_id
        WHERE bet_lot_id = ?
        ORDER BY bet_price DESC ";
    $stmt = $db->prepare($sql); // подготавливаем запрос, получаем stmt
    $stmt->bind_param("s", $lotId); //
    $stmt->execute(); // выполняем запрос
    $result = $stmt->get_result(); // получаем result
    return $result->fetch_all(MYSQLI_ASSOC);
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
                 lot_bet_step,
                 lot_category_id,
                 lot_author_id
                 )  VALUES (?,?,?,?,?,?,?,?)";

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
    $sql = "SELECT * FROM user WHERE user_email = ?";
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
                 user_registered,
                  user_email,
                 user_name,
                 user_password,
                 user_contact
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
