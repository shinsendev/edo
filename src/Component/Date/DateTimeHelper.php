<?php


namespace App\Component\DateTime;

/**
 * Class DateTimeHelper
 * @package App\Component\Time
 */
class DateTimeHelper
{
    public static function now()
    {
        return new \DateTime();
    }

    public static function humanNow()
    {
        $datetime = new \DateTime();
        return $datetime->format('Y-m-d H:i:s');
    }
}