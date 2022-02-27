<?php

/**
 * Format dollar amount to $xx,xxx.xx or -$xx,xxx.xx
 * @param float $amount
 * @return string
 */
function formatDollarAmount(float $amount): string {
    $isNegative = $amount < 0;
    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
}

/**
 * Format Date
 * @param string $date
 * @return false|string
 */
function formatDate(string $date): string {
    return date('M j, Y', strtotime($date));
}