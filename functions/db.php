<?php

function getDb(): mysqli
{
    $dbConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }
    return $dbConnection;
}

function getCategories(mysqli $db): array
{
    $sqlQuery = "SELECT * FROM category";
    $sqlQueryResult = mysqli_query($db, $sqlQuery);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}

function getLots(mysqli $db): array
{
    $sqlQuery = "SELECT *

    FROM lot
        INNER JOIN category ON category_id = category.id
        INNER JOIN user ON author_id = user.id  ORDER BY lot_create DESC ";


    $sqlQueryResult = mysqli_query($db, $sqlQuery);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}

function getLot(mysqli $db, int $lotId): array
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
