<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Reorder;


use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;

class ReorderDTOPost implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        // TODO: Implement proceed() method.
        dd($config);

        // we remove from the tree

        // we change the parent

        // we must change the position of the element
    }

}