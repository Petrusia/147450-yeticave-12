<?php
function getDateDiff(string $expire_at): array
{
    $dateDiff = strtotime($expire_at) - time();
    $time = floor($dateDiff / 60);
    $hours = floor($dateDiff / 3600);
    $minutes = $time - $hours*60;
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [
        'hours' => $time,
        'minutes' => $minutes
    ];

}
