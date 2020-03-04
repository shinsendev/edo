<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy;


interface DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config);
}