<?php


namespace App\Component\Fragment;


use App\Component\DTO\Model\NarrativeDTO;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Transformer\VersionDTOTransformer;
use Doctrine\ORM\EntityManagerInterface;

class FragmentSaver
{
    /**
     * @param EntityManagerInterface $em
     * @param NarrativeDTO $narrativeDTO
     * @throws \App\Component\Exception\EdoException
     */
    public static function save(EntityManagerInterface $em, NarrativeDTO $narrativeDTO)
    {
        // create Fragment
        $fragment = VersionDTOTransformer::toEntity($narrativeDTO, $em);
        SaveEntityHelper::saveEntity($em, $fragment);
    }
}