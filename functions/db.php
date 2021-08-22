<?php

// https://github.com/ro-htmlacademy/textbook/blob/main/54.md

/**
 * @param mysqli $mysqli
 * @param string $sql
 * @param array $params
 * @param string $types
 * @return mysqli_stmt
 */
function dbGetPrepareStmt(mysqli $mysqli,string $sql, array $params, string $types = '' ): mysqli_stmt
{
    if ($types === '') {
        $types = str_repeat('s', count($params));
    }
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
};


/**
 * @param mysqli $mysqli
 * @param string $sql
 * @param array $params
 * @param string $types
 * @return mysqli_result|mysqli_stmt
 */
function dbSelect(mysqli $mysqli,string $sql, array $params = [], string $types = '' ): mysqli_result|mysqli_stmt
{
    if (!$params) {
        return $mysqli->query($sql);
    }
    return dbGetPrepareStmt($mysqli, $sql, $params, $types)->get_result();
}

/**
 * @param mysqli $db
 * @param string $sqlQuery
 * @param array $params
 * @param string $types
 * @return array|null
 */
function dbFetchAssoc(mysqli $db, string $sqlQuery, array $params = [], string $types = ''): ?array
{
    $result =dbSelect($db, $sqlQuery, $params, $types);
    return $result->fetch_assoc();
}


/**
 * @param mysqli $db
 * @param string $sqlQuery
 * @param array $params
 * @param string $types
 * @return array|null
 */
function dbFetchAll(mysqli $db, string $sqlQuery, array $params = [], string $types = ''): ?array
{
    $result = dbSelect($db, $sqlQuery, $params, $types);
    return $result->fetch_all(MYSQLI_ASSOC);
}



/**
 * @param mysqli $db
 * @return array
 */
function getCategories(mysqli $db): array
{
    $sql = "SELECT * FROM category";
    $result = dbSelect($db, $sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


/**
 * @param mysqli $db
 * @param string $searchQuery
 * @param string $category
 * @param int $limit
 * @param int $offset
 * @return array
 */
function getLots(

    mysqli $db,
    string $searchQuery = '',
    string $category = '',
    int $limit = 9,
    int $offset = 0,
): array {
    $params = [];
    $sql = "SELECT
        lot_id,
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

    if($searchQuery) {
        $sql .= " AND MATCH(lot_name, lot_desc) AGAINST(?) ";
        $params[] = $searchQuery;
    }
    if($category) {
        $sql .= " AND category_name = ? ";
        $params[] = $category;
    }

    $sql .= "GROUP BY lot.lot_id
    ORDER BY lot_create DESC
    LIMIT ?
    OFFSET ?
    ";

    $params[] = $limit;
    $params[] = $offset;
  return dbFetchAll($db, $sql, $params);
}


/**
 * @param mysqli $db
 * @param int $lotId
 * @return array|null
 */
function getLotById(mysqli $db, int $lotId): ?array
{
    $sql = "SELECT * FROM lot
        INNER JOIN category ON category_id = lot_category_id
        WHERE lot_id = ?";
        return dbFetchAssoc($db, $sql, [$lotId]);
}

/**
 * @param mysqli $db
 * @param $lotId
 * @return array|null
 */
function getBetsByLotId(mysqli $db,  $lotId): ?array
{
    $sql = "SELECT bet_date, bet_price, bet_author_id, bet_lot_id, user_id, user_name
    FROM bet
        INNER JOIN user ON bet_author_id = user_id
        WHERE bet_lot_id = ?
        ORDER BY bet_price DESC ";
        return dbFetchAll($db, $sql, [$lotId]);
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
    dbGetPrepareStmt( $db, $sql,[
        $submittedData['lot-name'],
        $submittedData['lot-message'],
        $submittedData['lot-img'],
        $submittedData['lot-rate'],
        $submittedData['lot-date'],
        $submittedData['lot-step'],
        $submittedData['lot-category'],
        $authUser['user_id'],
    ]);

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
    return dbFetchAssoc($db, $sql, [$email]);
}

/**
 * @param mysqli $db
 * @param array $submittedData
 */
function saveUser(mysqli $db, array $submittedData)
{
    $sql = "INSERT INTO user (
                 user_email,
                 user_name,
                 user_password,
                 user_contact
                 )  VALUES (?,?,?,?)";
    dbGetPrepareStmt($db, $sql, [
        $submittedData['user-email'],
        $submittedData['user-name'],
        $submittedData['user-password'],
        $submittedData['user-message'],
    ]);
}

function getLotsCount($db, $searchQuery, $categoryQuery){
    $sql = "SELECT
        COUNT(lot_id) as count
        FROM lot ";
    if($searchQuery) {
        $sql .= " WHERE lot_end > NOW()
        AND MATCH(lot_name, lot_desc) AGAINST(?) ";
        $params[] = $searchQuery;
    }
    if($categoryQuery) {
        $sql .= " JOIN category ON lot_category_id = category_id
        WHERE lot_end > NOW()
        AND category_name = ?  ";
        $params[] = $categoryQuery;
    }
    return dbFetchAssoc($db, $sql, $params)['count'];
}

function saveBetData(mysqli $db, array $submittedData, array $authUser, int $lotId)
{
    $sql = "INSERT INTO bet (
                 bet_price,
                bet_author_id,
                bet_lot_id
                 )  VALUES (?,?,?)";
    dbGetPrepareStmt($db, $sql, [
        $submittedData['cost'],
        $authUser['user_id'],
        $lotId,
    ]);
}

function getMyBets(mysqli $db, int $userId): ?array
{
    $sql = " SELECT
    lot_id,
    lot_name,
    lot_desc,
    lot_img,
    lot_end,
    lot_winner_id,
    user_contact,
    category_name,
    bet_date,
    MAX(bet_price) AS lot_price

    FROM lot
         left join bet ON lot_id = bet_lot_id
         left join user ON lot_author_id = user_id
         left join category ON lot_category_id = category_id
WHERE bet_author_id = ?
GROUP BY lot_id
ORDER BY bet_date DESC";

    return  dbFetchAll($db, $sql, [$userId]);
}
