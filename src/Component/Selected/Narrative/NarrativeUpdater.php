<?php

declare(strict_types=1);

namespace App\Component\Selected\Narrative;

use App\Component\Date\DateConverter;
use App\Component\DTO\NarrativeDTO;
use App\Component\Fragment\FragmentCreator;
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

    /**
     * NarrativeUpdater constructor.
     * @param EntityManager $em
     */
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
        $this->updateNarrative($narrativeDTO, $narrative);
        $fragment = FragmentCreator::createFragment($narrativeDTO);
        $this->saveEntity($fragment);

        $qualification = FragmentCreator::createQualification($fragment, $narrative->getUuid());
        $this->saveEntity($qualification);

        return $this->createResponse($narrativeDTO, $narrative);
    }

    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function updateNarrative(NarrativeDTO $dto, Narrative $narrative)
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
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @return NarrativeDTO
     */
    private function createResponse(NarrativeDTO $dto, Narrative $narrative)
    {
        //from entity to DTO
        $dto->setCreatedAt(DateConverter::stringifyDatetime($narrative->getCreatedAt()));
        $dto->setUpdatedAt(DateConverter::stringifyDatetime($narrative->getUpdatedAt()));

        return $dto;
    }

    /**
     * @param $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function saveEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

}