<?php

declare(strict_types=1);

namespace App\Component\Narratable\Narrative;

use App\Component\Configuration\NarrativeConfiguration;
use App\Component\DTO\NarrativeDTO;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Date\DateTimeHelper;
use App\Component\Transformer\FragmentDTOTransformer;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Fragment;
use App\Entity\Narrative;
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
        // as long as there are more fragments than authorized, we delete them one by one
        while ($this->countFragments($narrative) >=  NarrativeConfiguration::getMaxVersionningFragments())
        {
            // delete oldest fragment and its qualification
            $this->deleteFragment($narrative);
        }

        // we save the fragments
        SaveEntityHelper::saveEntity($this->em, FragmentDTOTransformer::toEntity($narrativeDTO, $this->em));

        return NarrativeResponseCreator::createResponse($narrativeDTO, $narrative);
    }

    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @throws \Exception
     */
    private function updateNarrative(NarrativeDTO $dto, Narrative $narrative)
    {
        // update parent with $narrativeDTO
        $narrative = NarrativeDTOTransformer::toEntity($dto, $this->em, $narrative);

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
        return $this->em->getRepository(Fragment::class)->countNarrativeFragments($narrative->getUuid());
    }

    /**
     * @param Narrative $narrative
     * @throws \App\Component\Exception\EdoException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function deleteFragment(Narrative $narrative)
    {
        $arrayLastFragment = $this->fragmentRepository->findNarrativeLastFragment($narrative->getUuid());
        $lastFragment = $this->fragmentRepository->findOneByUuid($arrayLastFragment['uuid']);
        $this->em->remove($lastFragment);
        $this->em->flush();
    }

}