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
}