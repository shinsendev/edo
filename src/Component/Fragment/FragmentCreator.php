<?php


namespace App\Component\Fragment;


use App\Component\DTO\NarrativeDTO;
use App\Component\Selected\SelectedType;
use App\Entity\Fragment;
use App\Entity\Qualification;

class FragmentCreator
{
    /**
     * @Description = create new fragment entity
     *
     * @param NarrativeDTO $narrativeDTO
     * @return Fragment
     * @throws \Exception
     */
    public static function createFragment(NarrativeDTO $narrativeDTO):Fragment
    {
        $fragment = new Fragment();
        $fragment->setTitle($narrativeDTO->getTitle());
        $fragment->setContent($narrativeDTO->getContent());

        return $fragment;
    }

    /**
     * @param Fragment $fragment
     * @param $narrativeUuid
     * @return Qualification
     */
    public static function createQualification(Fragment $fragment, $narrativeUuid)
    {
        // save qualification relation between fragment and narrative
        $qualification = new Qualification();
        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
        $qualification->setSelectedUuid($narrativeUuid);
        $qualification->setFragment($fragment);

        return $qualification;
    }

}