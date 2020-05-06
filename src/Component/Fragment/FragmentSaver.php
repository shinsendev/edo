<?php


namespace App\Component\Fragment;


use App\Component\DTO\Model\FragmentDTO;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Transformer\VersionDTOTransformer;
use Doctrine\ORM\EntityManagerInterface;

class FragmentSaver
{
    /**
     * @param EntityManagerInterface $em
     * @param FragmentDTO $fragmentDTO
     * @throws \App\Component\Exception\EdoException
     */
    public static function save(EntityManagerInterface $em, FragmentDTO $fragmentDTO)
    {
        // create Fragment
        $fragment = VersionDTOTransformer::toEntity($fragmentDTO, $em);
        SaveEntityHelper::saveEntity($em, $fragment);
    }
}