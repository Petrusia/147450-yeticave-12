<?php
declare(strict_types=1);
require __DIR__ . '/initialize.php';

$title = 'Все лоты';

$searchQuery = trim($_GET['category'] ?? '');
$currentPage = $_GET['page'] ?? 1;
$lotsCount = getLotsCount($db, $searchQuery, SEARCH_BY_CATEGORY);
$lotsPerPage = LOTS_PER_PAGE;
$lotsPagesCount = ceil($lotsCount / $lotsPerPage);
for ($i = 1; $i <= $lotsPagesCount; ++$i) {
    $lotsPagesRange[] = $i;
}
$offset =  $lotsPerPage  * ($currentPage - 1);


$lots = getPages($db, $searchQuery, $lotsPerPage, $offset, SEARCH_BY_CATEGORY);

echo renderTemplate('all-lots-template.php', $title, $authUser, $categories,  [
    'categories' => $categories,
    'lots' => $lots,
    'searchQuery' => $searchQuery,
    'lotsPagesCount' => $lotsPagesCount,
    'currentPage' => $currentPage,
    'lotsPagesRange' => $lotsPagesRange
], $searchQuery);


