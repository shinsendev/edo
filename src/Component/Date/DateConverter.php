<?php

declare(strict_types=1);

namespace App\Component\Date;

/**
 * Class DateConverter
 * @package App\Component\Date
 */
class DateConverter
{
    /**
     * @param \DateTime $datetime
     * @return string
     */
    public static function stringifyDatetime(\DateTime $datetime) {
        return $datetime->format('Y-m-d H:i:s');
    }
}