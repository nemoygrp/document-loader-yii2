<?php

namespace app\helpers;

use DateTime;

class DateHelper
{
    /**
     * Возвращает отформатированную дату.
     *
     * @param null|string $date
     * @param null|string $format
     * @return string
     */
    public static function getFormattedDate(?string $date = null, ?string $format = 'd.m.Y'): string
    {
        $time = new DateTime($date);

        return $time->format($format);
    }
}