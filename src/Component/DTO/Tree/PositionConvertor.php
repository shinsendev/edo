<?php

declare(strict_types=1);


namespace App\Component\DTO\Tree;

use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PositionConvertor
 * @package App\Component\DTO\Tree
 */
class PositionConvertor
{
    public static function getNarrativeUuid(Position $position, EntityManagerInterface $em)
    {
        /** Narrative Uuid */
        return ($em->getRepository(Position::class)->findNarrative($position->getId()))->getUuid();
    }
}