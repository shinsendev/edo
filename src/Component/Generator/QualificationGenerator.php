<?php

declare(strict_types=1);

namespace App\Component\Generator;

use App\Entity\Qualification;

/**
 * Class QualificationTestGenerator
 * @package App\Component\Generator
 */
class QualificationGenerator
{
    /**
     * @Description generate qualification for a fragment and a selected
     *
     * @param $fragment
     * @param $selectedUuid
     * @param int $type
     * @return Qualification
     */
    public static function generateQualification($fragment, $selectedUuid, $type = 1)
    {
        $qualification = new Qualification();
        $qualification->setFragment($fragment);
        $qualification->setSelectedType($type);
        $qualification->setSelectedUuid($selectedUuid);

        return $qualification;
    }
}