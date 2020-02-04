<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Selected\Narrative\NarrativeCreator;
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

    /** @var NarrativeCreator  */
    private $creator;

    /**
     * NarrativeDataPersister constructor.
     * @param NarrativeRepository $repository
     * @param NarrativeUpdater $updater
     * @param NarrativeCreator $creator
     */
    public function __construct(
        NarrativeRepository $repository,
        NarrativeUpdater $updater,
        NarrativeCreator $creator
    )
    {
        $this->repository = $repository;
        $this->updater = $updater;
        $this->creator = $creator;
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
     * @throws \Exception
     */
    public function persist($dto, array $context = [])
    {
        if (!$narrative = $this->repository->findOneByUuid($dto->getUuid())) {
            // it's a new  narrative, this is an insert
            $this->creator->save($dto);
        }
        else {
            // narrative already exists, so it is an update
            $this->updater->update($dto, $narrative);
        }

        return $dto;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}