<?php

declare(strict_types=1);


namespace App\Component\DTO\Tree;

use App\Entity\Narrative;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PositionConvertor
 * @package App\Component\DTO\Tree
 */
class PositionConvertor
{
    /**
     * description : convert position into Narrative Uuid, used by Narrative DTO
     *
     * @param Position $position
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public static function getNarrativeUuid(Position $position, EntityManagerInterface $em)
    {
        /** Narrative Uuid */
        return ($em->getRepository(Position::class)->findNarrative($position->getId()))->getUuid();
    }

    /**
     * description : extract root position from narrative
     *
     * @param Narrative $narrative
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public static function getRootPosition(Narrative $narrative, EntityManagerInterface $em)
    {
        return ($em->getRepository(Position::class)->findOneByNarrative($narrative))->getRoot();
    }
}