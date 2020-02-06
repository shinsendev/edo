<?php

declare(strict_types=1);

namespace App\Component\Selected\Narrative;

use App\Component\Configuration\NarrativeConfiguration;
use App\Component\DTO\NarrativeDTO;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Date\DateTimeHelper;
use App\Entity\Narrative;
use App\Entity\Qualification;
use App\Repository\FragmentRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class NarrativeUpdater
 * @package App\Component\Narrative
 */
class NarrativeUpdater
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var FragmentRepository  */
    private $fragmentRepository;

    public function __construct(EntityManagerInterface $em, FragmentRepository $fragmentRepository)
    {
        $this->em = $em;
        $this->fragmentRepository = $fragmentRepository;
    }

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
        SaveEntityHelper::saveEntity($this->em, $narrative);

        // count fragments
        if ($this->countFragments($narrative) > NarrativeConfiguration::MAX_VERSIONNING_FRAGMENTS) {
            // delete oldest fragment and its qualification
            $arrayLastFragment = $this->fragmentRepository->findNarrativeLastFragment($narrative->getUuid());
            $lastFragment = $this->fragmentRepository->findOneByUuid($arrayLastFragment['uuid']);
            $this->em->remove($lastFragment);
            $this->em->flush();
        }
        FragmentSaver::save($this->em, $narrativeDTO, $narrative->getUuid());

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

    /**
     * @param Narrative $narrative
     * @return int
     */
    public function countFragments(Narrative $narrative)
    {
        $qualifications = $this->em->getRepository(Qualification::class)->findBySelectedUuid($narrative->getUuid());
        return count($qualifications);
    }

}