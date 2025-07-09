<?php
$startTime = '2025-07-09 8:52:00';
$endTime = '2025-07-09 9:00:00';

if (isNowBetween($startTime, $endTime)) {
    echo "true";
} else {
    echo "false";
}
function isNowBetween(string $startTime, string $endTime): bool {
    $timezone = new DateTimeZone('Europe/Berlin');
    $now = new DateTime('now', $timezone);
    $start = new DateTime($startTime, $timezone);
    $end = new DateTime($endTime, $timezone);

    return $now >= $start && $now <= $end;
}



?>