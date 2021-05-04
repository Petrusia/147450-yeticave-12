<?php

function getDateDiff(string $expire_at): array
{
    $period = strtotime($expire_at) - time();
    $hours = floor($period / 3600);
    $minutes = 60 - date('i');

    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [
        'hours' => $hours,
        'minutes' => $minutes
    ];
}
