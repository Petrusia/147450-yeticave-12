<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Результаты поиска';

$searchQuery = esc(trim($_GET['search'] ?? ''));
$currentPage = intval($_GET['page'] ?? 1);

$sql = "SELECT
        COUNT(lot_id) as count
        FROM lot
        WHERE lot_end > NOW()
        AND MATCH(lot_name, lot_desc) AGAINST(?)";
$result = dbFetchAssoc($db, $sql, $searchQuery);

$lotsCount = $result['count'];
$lotsPerPage = LOTS_PER_PAGE;
$lotsPagesCount = ceil($lotsCount / $lotsPerPage);
$lotsPagesRange = range(1, $lotsPagesCount);
$offset =  $lotsPerPage  * ($currentPage - 1);

$lots = getLots($db, $searchQuery, $lotsPerPage, $offset);

echo renderTemplate('search-template.php', $title, $authUser, $categories, [
    'categories' => $categories,
    'lots' => $lots,
    'searchQuery' => $searchQuery,
    'lotsPagesCount' => $lotsPagesCount,
    'currentPage' => $currentPage,
    'lotsPagesRange' => $lotsPagesRange
]);


