<?php

declare(strict_types=1);


namespace App\Component\DTO\Tree;

use App\Entity\Fragment;
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
    public static function getFragmentUuid(Position $position, EntityManagerInterface $em)
    {
        /** Narrative Uuid */
        return ($em->getRepository(Position::class)->findFragment($position->getId()))->getUuid();
    }

    /**
     * description : extract root position from narrative
     *
     * @param Fragment $fragment
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public static function getRootPosition(Fragment $fragment, EntityManagerInterface $em)
    {
        return ($em->getRepository(Position::class)->findOneByFragment($fragment))->getRoot();
    }

    /**
     * description : extract parent position from narrative
     *
     * @param string $fragmentUuid
     * @param EntityManagerInterface $em
     * @return mixed
     */
    public static function getParentPositionFromNarrativeUuid(string $fragmentUuid, EntityManagerInterface $em)
    {
        $parentFragment = $em->getRepository(Fragment::class)->findOneByUuid($fragmentUuid);
        return $em->getRepository(Position::class)->findOneByFragment($parentFragment);
    }

}