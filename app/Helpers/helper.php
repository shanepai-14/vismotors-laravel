<?php


use Carbon\Carbon;


if (!function_exists('getDaySuffix')) {
    function getDaySuffix($day) {
        if (!in_array(($day % 100), [11, 12, 13])) {
            switch ($day % 10) {
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';
            }
        }
        return 'th';
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return Carbon::parse($date)->format('F j, Y');
    }
}
