<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Все лоты';
$categoryPage = true;

$searchQuery = esc(trim($_GET['category'] ?? ''));
$currentPage = intval( $_GET['page'] ?? 1);

foreach ($categories  as  $category) {
    $categoryName[] = $category["category_name"];
 }
var_dump(in_array($searchQuery, $categories));
if(!in_array($searchQuery, $categoryName)) {
    httpError($categories,404,HEADER_CATEGORY_ERR );
}


        $sql = "SELECT
        COUNT(lot_id) as count
        FROM lot
        JOIN category ON lot_category_id = category_id
        WHERE lot_end > NOW()
        AND category_name = ? ";
$result = dbFetchAssoc($db, $sql, $searchQuery);

$lotsCount = $result['count'];
$lotsPerPage = LOTS_PER_PAGE;
$lotsPagesCount = ceil($lotsCount / $lotsPerPage);

if($currentPage < 1 || $currentPage > $lotsPagesCount) {
    httpError($categories,404,HEADER_PAGE_NUMBER_ERR );
}

$lotsPagesRange = range(1, $lotsPagesCount);
$offset =  $lotsPerPage  * ($currentPage - 1);


$lots = getLots($db, $searchQuery, $lotsPerPage, $offset, $categoryPage);

echo renderTemplate('all-lots-template.php', $title, $authUser, $categories,  [
    'categories' => $categories,
    'lots' => $lots,
    'searchQuery' => $searchQuery,
    'lotsPagesCount' => $lotsPagesCount,
    'currentPage' => $currentPage,
    'lotsPagesRange' => $lotsPagesRange
], $searchQuery);


