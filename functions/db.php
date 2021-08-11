<?php

/**
 * @param mysqli $db
 * @return array
 */
function getCategories(mysqli $db): array
{
    $sql = "SELECT * FROM category";
    $result = $db->query( $sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


/**
 * @param mysqli $db
 * @param string $searchQuery
 * @param int $limit
 * @param int $offset
 * @return array
 */
function getLots(

    mysqli $db,
    string $searchQuery = '',
    int $limit = 9,
    int $offset = 0,
): array {
    $sql = "SELECT  lot.lot_id,
        lot_name,
        lot_desc,
        lot_img,
        lot_create,
        lot_end,
        lot_category_id,
        category_name,
        COALESCE( MAX(bet_price), lot_price) AS lot_price,
        COUNT(bet.bet_id) bet_count

FROM lot
         left  join category ON lot_category_id = category_id
         left  join user ON lot_author_id = user_id
         left  join bet ON lot_id = bet_lot_id
WHERE lot_end > NOW()";

    if($_GET['search'] ?? null ) {
        $sql .= " AND MATCH(lot_name, lot_desc) AGAINST(?) ";
    }
    if($_GET['category'] ?? null ) {
        $sql .= " AND category_name = ? ";
    }

    $sql .= "GROUP BY lot.lot_id
ORDER BY lot_create DESC
LIMIT ?
OFFSET ?
";

    $stmt = $db->prepare($sql); // подготавливаем запрос, получаем stmt
    if($searchQuery === '') {
        $stmt->bind_param("ss",  $limit, $offset);
    } else {
        $stmt->bind_param("sss", $searchQuery, $limit, $offset); //
    }
    $stmt->execute(); // выполняем запрос
    $result = $stmt->get_result(); // получаем result
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

function getBetsByLotId(mysqli $db,  $lotId): ?array
{
    $sql = "SELECT * FROM bet
        INNER JOIN user ON bet_author_id = user_id
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
