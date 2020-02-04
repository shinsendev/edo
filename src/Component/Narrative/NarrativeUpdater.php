<?php

declare(strict_types=1);

namespace App\Component\Narrative;

use App\Component\Date\DateConverter;
use App\Component\DTO\NarrativeDTO;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManager;

/**
 * Class NarrativeUpdater
 * @package App\Component\Narrative
 */
class NarrativeUpdater
{
    /** @var EntityManager  */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @description : update narrative entity and create new fragment
     *
     * @param NarrativeDTO $narrativeDTO
     * @param Narrative $narrative
     * @return NarrativeDTO
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(NarrativeDTO $narrativeDTO, Narrative $narrative)
    {
        $this->handleNarrative($narrativeDTO, $narrative);
        return $this->createResponse($narrativeDTO, $narrative);
    }

    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function handleNarrative(NarrativeDTO $dto, Narrative $narrative)
    {
        // update tree hierarchy with $narrativeDTO
        //todo : to implement

        // update updatedAt
        $now = new \DateTime();
        $narrative->setUpdatedAt($now);

        // save narrative
        $this->em->persist($narrative);
        $this->em->flush();
    }

    /**
     * @param NarrativeDTO $narrativeDTO
     * @param Narrative $narrative
     */
    private function handleFragments(NarrativeDTO $narrativeDTO, Narrative $narrative)
    {
        //todo: to implement
    }

    private function createResponse(NarrativeDTO $dto, Narrative $narrative)
    {
        //from entity to DTO
        $dto->setCreatedAt(DateConverter::stringifyDatetime($narrative->getCreatedAt()));
        $dto->setUpdatedAt(DateConverter::stringifyDatetime($narrative->getUpdatedAt()));

        return $dto;
    }

}