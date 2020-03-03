<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Narratable\Narrative\NarrativeCreator;
use App\Component\Narratable\Narrative\NarrativeUpdater;
use App\Repository\NarrativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FragmentDataPersister
 * @package App\Component\DataPersister
 */
final class NarrativeDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var NarrativeRepository  */
    private $repository;

    /** @var EntityManagerInterface */
    private $em;

    /** @var NarrativeUpdater  */
    private $updater;

    /** @var NarrativeCreator  */
    private $creator;

    /** @var ValidatorInterface  */
    private $validator;

    /**
     * NarrativeDataPersister constructor.
     * @param NarrativeRepository $repository
     * @param NarrativeUpdater $updater
     * @param NarrativeCreator $creator
     * @param ValidatorInterface $validator,
     * @param EntityManagerInterface $em
     */
    public function __construct(
        NarrativeRepository $repository,
        NarrativeUpdater $updater,
        NarrativeCreator $creator,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    )
    {
        $this->repository = $repository;
        $this->updater = $updater;
        $this->creator = $creator;
        $this->validator = $validator;
        $this->em = $em;
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

    /**
     * @param $narrativeDTO
     * @param array $context
     */
    public function remove($narrativeDTO, array $context = [])
    {
        $uuid = $narrativeDTO->getUuid();
        if (!$narrative = $this->repository->findOneByUuid($uuid)) {
            throw new NotFoundHttpException("No narrative found with uuid" . $uuid);
        }
        $this->em->remove($narrative);
        $this->em->flush();
    }
}