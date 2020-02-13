<?php


namespace App\Component\Fragment;


use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Generator\FragmentGenerator;
use App\Component\Generator\QualificationGenerator;
use App\Component\Relation\Qualifier;
use App\Component\Transformer\FragmentDTOTransformer;
use Doctrine\ORM\EntityManagerInterface;

class FragmentSaver
{
    /**
     * @param EntityManagerInterface $em
     * @param $narrativeDTO
     * @param $uuid
     */
    public static function save(EntityManagerInterface $em, $narrativeDTO, $uuid)
    {
        // create Fragment
        $fragment = FragmentDTOTransformer::toEntity($narrativeDTO);
        SaveEntityHelper::saveEntity($em, $fragment);

        // create Qualification
        $qualification = Qualifier::createQualification($fragment, $uuid);
        SaveEntityHelper::saveEntity($em, $qualification);
    }

    /**
     * @param EntityManagerInterface $em
     * @param string $uuid
     * @throws \Exception
     */
    public static function addFragmentToNarrative(EntityManagerInterface $em, string $uuid)
    {
        $fragment = FragmentGenerator::generate($uuid);
        SaveEntityHelper::saveEntity($em, $fragment);
        $qualification = QualificationGenerator::generateQualification($fragment, $uuid);
        SaveEntityHelper::saveEntity($em, $qualification);
    }
}