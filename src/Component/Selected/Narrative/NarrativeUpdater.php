<?php

declare(strict_types=1);

namespace App\Component\Selected\Narrative;

use App\Component\DTO\NarrativeDTO;
use App\Component\EntityManager\EntityManagerTrait;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Date\DateTimeHelper;
use App\Entity\Narrative;
use App\Entity\Qualification;

/**
 * Class NarrativeUpdater
 * @package App\Component\Narrative
 */
class NarrativeUpdater
{
    use EntityManagerTrait;

    /**
     * @description : update narrative entity and create new fragment
     *
     * @param NarrativeDTO $narrativeDTO
     * @param Narrative $narrative
     * @return NarrativeDTO
     * @throws \Exception
     */
    public function update(NarrativeDTO $narrativeDTO, Narrative $narrative)
    {
        $this->updateNarrative($narrativeDTO, $narrative);
        FragmentSaver::save($this->em, $narrativeDTO, $narrative->getUuid());
        SaveEntityHelper::saveEntity($this->em, $narrative);
        dd($narrative);

        // count fragments
        $qualifications = $this->em->getRepository(Qualification::class)->findAll();


        return NarrativeResponseCreator::createResponse($narrativeDTO, $narrative);
    }

    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @throws \Exception
     */
    private function updateNarrative(NarrativeDTO $dto, Narrative $narrative)
    {
        // update tree hierarchy with $narrativeDTO
        //todo : to implement

        // update updatedAt
        $narrative->setUpdatedAt(DateTimeHelper::now());

        // save narrative
        SaveEntityHelper::saveEntity($this->em, $narrative);
    }

}