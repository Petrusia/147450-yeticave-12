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
    $sqlQuerySelect = "SELECT * FROM category";
    $sqlQueryResult = mysqli_query($db, $sqlQuerySelect);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}

function getLots(mysqli $db): array
{
    $sqlQuerySelect = "SELECT *

    FROM lot
        INNER JOIN category ON category_id = category.id
        INNER JOIN user ON author_id = user.id  ORDER BY lot_start DESC ";


    $sqlQueryResult = mysqli_query($db, $sqlQuerySelect);

    if (!$sqlQueryResult) {
        echo mysqli_error($db);
    }
    return mysqli_fetch_all($sqlQueryResult, MYSQLI_ASSOC);
}
