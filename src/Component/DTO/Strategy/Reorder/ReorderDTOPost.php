<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Reorder;


use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Entity\Narrative;

class ReorderDTOPost implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        // TODO: Implement proceed() method.

        // we remove from the tree
        $config->getEm()->getRepository(Narrative::class)->removeFromTree($config->getEntity());
        $config->getEm()->clear();

        dd($config->getEntity());

//        $em->clear();

        // we change the parent

        // we must change the position of the element

        // we have to update the creation date of the fragment with the creation date of the first fragment
    }

}