<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Все лоты';

$categoryQuery = trim($_GET['category'] ?? '');
$currentPage = intval( $_GET['page'] ?? 1);

foreach ($categories  as  $category) {
    $categoryName[] = $category["category_name"];
 }

if(!in_array($categoryQuery, $categoryName)) {
    httpError($categories,404, HEADER_CATEGORY_ERR, $authUser );
}

$lotsCount  = getLotsCount($db, '', $categoryQuery);
$lotsPerPage = LOTS_PER_PAGE;
$lotsPagesCount = ceil($lotsCount / $lotsPerPage) ?: 1;
$lotsPagesRange = range(1, $lotsPagesCount);
$offset =  $lotsPerPage  * ($currentPage - 1);

if($currentPage < 1 || $currentPage > $lotsPagesCount) {
    httpError($categories,404,HEADER_PAGE_NUMBER_ERR, $authUser );
}

$lots = getLots($db,'', $categoryQuery, $lotsPerPage, $offset);

echo renderTemplate('all-lots-template.php', $title, $authUser, $categories,  [
    'categories' => $categories,
    'lots' => $lots,
    'searchQuery' => $categoryQuery,
    'lotsPagesCount' => $lotsPagesCount,
    'currentPage' => $currentPage,
    'lotsPagesRange' => $lotsPagesRange
], $categoryQuery);


