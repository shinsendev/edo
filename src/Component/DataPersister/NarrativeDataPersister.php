<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Narratable\Narrative\NarrativeCreator;
use App\Component\Narratable\Narrative\NarrativeUpdater;
use App\Repository\FictionRepository;
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
     * @param $narrativeDTO
     * @param array $context
     * @return bool
     */
    public function supports($narrativeDTO, array $context = []): bool
    {
        return $narrativeDTO instanceof NarrativeDTO;
    }

    /**
     * @param $narrativeDTO
     * @param array $context
     * @return object|void
     * @throws \Exception
     */
    public function persist($narrativeDTO, array $context = [])
    {
        if (!$narrative = $this->repository->findOneByUuid($narrativeDTO->getUuid())) {
            // it's a new  narrative, this is an insert
            $this->creator->save($narrativeDTO);
        }
        else {
            // narrative already exists, so it is an update
            $this->updater->update($narrativeDTO, $narrative);
        }

        return $narrativeDTO;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}