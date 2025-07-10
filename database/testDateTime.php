<?php

use function PHPSTORM_META\type;

$startTime = '11:40:00';
$endTime = '12:00:00';

$startDate = '2025-07-10';
$endDate = '2025-07-11';

$timeFormat = 'H:i:s';
$dateFormat = 'Y-m-d';

$now = new DateTime('now', new DateTimeZone('Europe/Berlin'));

$nowTime = $now->format('H:i:s');
$nowDate = $now->format('Y-m-d');

function createDateTimeFormat($dateTime, $format)
{
    $dateTime = str_replace(' ', '', $dateTime);

    trim($dateTime);

    $dateTime = DateTime::createFromFormat($format, $dateTime);

    if (!$dateTime) {
        return null; // Ungültiges Datumsformat
    }
    $dateTime = $dateTime->format($format);
    if ($dateTime !== false) {
        return $dateTime;
    } else {
        return null;
    }
}

$startDate = createDateTimeFormat($startDate, $dateFormat);
$endDate = createDateTimeFormat($endDate, $dateFormat);

echo $startTime . "<br>";
echo $endTime . "<br>";


if($startDate !== null && $endDate !== null) {
    if ($nowDate >= $startDate && $nowDate <= $endDate) {
        echo "Das Datum liegt im Bereich. ";
    } else {
        echo "Das Datum liegt nicht im Bereich. ";
    }
} else {
    echo "Ungültiges Datumsformat.<br>";
}

if($startTime !== null && $endTime !== null) {
    if ($nowTime >= $startTime && $nowTime <= $endTime) {
        echo "Die Zeit liegt im Bereich.";
    } else {
        echo "Die Zeit liegt nicht im Bereich.";
    }
} else {
    echo "Ungültiges Zeitformat.<br>";
}

