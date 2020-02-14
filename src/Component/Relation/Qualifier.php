<?php

declare(strict_types=1);

namespace App\Component\Relation;

use App\Component\Narratable\SelectedType;
use App\Entity\Fragment;
use App\Entity\Qualification;

/**
 * Create qualification relation
 *
 * Class Qualifier
 * @package App\Component\Relation
 */
class Qualifier
{
    /**
     * @param Fragment $fragment
     * @param $narrativeUuid
     * @return Qualification
     */
    public static function createQualification(Fragment $fragment, string $narrativeUuid)
    {
        // save qualification relation between fragment and narrative
        $qualification = new Qualification();
        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
        $qualification->setSelectedUuid($narrativeUuid);
        $qualification->setFragment($fragment);

        return $qualification;
    }
}