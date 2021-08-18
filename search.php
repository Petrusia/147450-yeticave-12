<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Результаты поиска';

$searchQuery = trim($_GET['search'] ?? '');
$currentPage = intval($_GET['page'] ?? 1);
$lotsCount = getLotsCount($db, $searchQuery, '');
$lotsPerPage = LOTS_PER_PAGE;
$lotsPagesCount = ceil($lotsCount / $lotsPerPage) ?: 1;
$lotsPagesRange = range(1, $lotsPagesCount);
$offset =  $lotsPerPage  * ($currentPage - 1);

if($currentPage < 1 || $currentPage > $lotsPagesCount) {
    httpError($categories, $authUser,404, HEADER_PAGE_NUMBER_ERR);
}
$lots = getLots($db, $searchQuery,'', $lotsPerPage, $offset);

echo renderTemplate('search-template.php', $title, $authUser, $categories, [
    'categories' => $categories,
    'lots' => $lots,
    'searchQuery' => $searchQuery,
    'lotsPagesCount' => $lotsPagesCount,
    'currentPage' => $currentPage,
    'lotsPagesRange' => $lotsPagesRange
]);


