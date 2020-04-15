<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Reorder;


use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\DTO\Tree\PositionConvertor;
use App\Entity\Position;

class ReorderDTOPost implements DTOStrategyInterface
{
    /**
     * @param DTOStrategyConfig $config
     */
    public function proceed(DTOStrategyConfig $config)
    {
        $em = $config->getEm();

        // we extract the position to update
        $narrative = $config->getEntity();
        $position = $em->getRepository(Position::class)->findOneByNarrative($narrative);
        $createdAt = $position->getCreatedAt();

        // we remove from the tree only the selected narrative (not its children), the narrative will be deleted but all of the tree info will be updated correctly
//        $em->getRepository(Position::class)->removeFromTree($position);
//        $em->clear();
        // todo: check if everything is ok = left and right change correctly when using simple doctrine remove and not removeFromTree (be carefull, there is a warning in comments in doctrine extension for using removeFromTree)
        $em->remove($position);
        $em->flush();

        // change the parent of the narrative, if it's null, it means there is no parent
        $parentPosition = PositionConvertor::getParentPositionFromNarrativeUuid($config->getDto()->getParentUuid(), $em);
        $position->setParent($parentPosition);
        // we restore the first creation date of the position before we deleted it
        $position->setCreatedAt($createdAt);

        $narrative->setPosition($position);
        $em->persist($position);
        $em->persist($narrative);

        // save entity
        $em->flush();

        // we set the position of the narrative in the node
        //todo: set the narrative position, how ???

    }

}