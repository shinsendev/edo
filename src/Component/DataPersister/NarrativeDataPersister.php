<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\NarrativeDTO;
use App\Component\DTO\Strategy\Narrative\NarrativeDTOSave;
use App\Component\DTO\Strategy\Narrative\NarrativeDTOUpdate;
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

    /** @var ValidatorInterface  */
    private $validator;

    /**
     * NarrativeDataPersister constructor.
     * @param NarrativeRepository $repository
     * @param ValidatorInterface $validator,
     * @param EntityManagerInterface $em
     */
    public function __construct(
        NarrativeRepository $repository,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    )
    {
        $this->repository = $repository;
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
            $context= new DTOContext(new NarrativeDTOSave(), $narrativeDTO, $this->em);
        }
        else {
            // narrative already exists, so it is an update
            $context = new DTOContext(new NarrativeDTOUpdate(), $narrativeDTO, $this->em, $narrative);
        }

        return $context->proceed();
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