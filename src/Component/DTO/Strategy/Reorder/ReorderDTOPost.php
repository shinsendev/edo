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
        $em = $config->getEm();

        // we extract the narrative to update
        $narrativeToUpdate = $config->getEntity();

        // we remove from the tree only the selected narrative (not its children), the narrative will be deleted but all of the tree info will be updated correctly
        $em->getRepository(Narrative::class)->removeFromTree($config->getEntity());
        $em->clear();
        $em->flush();

        // if needed we change the parent of the narrative
        if ($parentUuid = $config->getDto()->getParentUuid()) {
            $narrativeToUpdate->setParent($parentUuid);
        }

        // save entity
        $em->persist($narrativeToUpdate);
        $em->flush();
        dd($narrativeToUpdate);


        //0000000077f289e9000000001c87a96d
        // update position
        dd($narrativeToUpdate->getUuid());
    }

}