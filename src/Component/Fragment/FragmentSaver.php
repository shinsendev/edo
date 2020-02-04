<?php


namespace App\Component\Fragment;


use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Relation\Qualifier;
use App\Component\Transformer\FragmentDTOTransformer;

class FragmentSaver
{
    public static function save($em, $narrativeDTO, $uuid)
    {
        // create Fragment
        $fragment = FragmentDTOTransformer::toEntity($narrativeDTO);
        SaveEntityHelper::saveEntity($em, $fragment);

        // create Qualification
        $qualification = Qualifier::createQualification($fragment, $uuid);
        SaveEntityHelper::saveEntity($em, $qualification);
    }
}