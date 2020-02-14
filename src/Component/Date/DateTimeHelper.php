<?php


namespace App\Component\Date;

/**
 * Class DateTimeHelper
 * @package App\Component\Time
 */
class DateTimeHelper
{
    /**
     * @return \DateTime
     * @throws \Exception
     */
    public static function now()
    {
        return new \DateTime();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function humanNow()
    {
        $datetime = new \DateTime();
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public static function stringify(\DateTime $dateTime)
    {
        return $dateTime->format('Y-m-d H:i:s');
    }
}