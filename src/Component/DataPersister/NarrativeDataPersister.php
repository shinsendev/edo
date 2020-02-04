<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Selected\Narrative\NarrativeUpdater;
use App\Repository\NarrativeRepository;

/**
 * Class FragmentDataPersister
 * @package App\Component\DataPersister
 */
final class NarrativeDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var NarrativeRepository  */
    private $repository;

    /** @var NarrativeUpdater  */
    private $updater;

    /**
     * NarrativeDataPersister constructor.
     * @param NarrativeRepository $repository
     * @param NarrativeUpdater $updater
     */
    public function __construct(NarrativeRepository $repository, NarrativeUpdater $updater)
    {
        $this->repository = $repository;
        $this->updater = $updater;
    }

    /**
     * @param $data
     * @param array $context
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof NarrativeDTO;
    }

    /**
     * @param $dto
     * @param array $context
     * @return object|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persist($dto, array $context = [])
    {
        if (!$narrative = $this->repository->findOneByUuid($dto->getUuid())) {
            // this is an insert
        }
        else {
            //this is an update
            $this->updater->update($dto, $narrative);
        }

        return $dto;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}