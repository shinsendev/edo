<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Strategy\Narrative\Save\FragmentDTOSave;
use App\Component\DTO\Strategy\Narrative\Update\NarrativeDTOUpdate;
use App\Repository\FragmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NarrativeDataPersister
 * @package App\Component\DataPersister
 */
final class FragmentDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var FragmentRepository  */
    private $repository;

    /** @var EntityManagerInterface */
    private $em;

    /** @var ValidatorInterface  */
    private $validator;

    /**
     * NarrativeDataPersister constructor.
     * @param FragmentRepository $repository
     * @param ValidatorInterface $validator,
     * @param EntityManagerInterface $em
     */
    public function __construct(
        FragmentRepository $repository,
        ValidatorInterface $validator,
        EntityManagerInterface $em
    )
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->em = $em;
    }

    /**
     * @param $fragmentDTO
     * @param array $context
     * @return bool
     */
    public function supports($fragmentDTO, array $context = []): bool
    {
        return $fragmentDTO instanceof FragmentDTO;
    }

    /**
     * @param $fragmentDTO
     * @param array $context
     * @return object|void
     * @throws \Exception
     */
    public function persist($fragmentDTO, array $context = [])
    {
        if (!$narrative = $this->repository->findOneByUuid($fragmentDTO->getUuid())) {
            // it's a new  narrative, this is an insert
            $context= new DTOContext(new FragmentDTOSave(), $fragmentDTO, $this->em);
        }
        else {
            // narrative already exists, so it is an update
            $context = new DTOContext(new FragmentDTOUpdate(), $fragmentDTO, $this->em, ['narrative' => $narrative]);
        }

        return $context->proceed();
    }

    /**
     * @param $fragmentDTO
     * @param array $context
     */
    public function remove($fragmentDTO, array $context = [])
    {
        $uuid = $fragmentDTO->getUuid();
        if (!$fragment = $this->repository->findOneByUuid($uuid)) {
            throw new NotFoundHttpException("No narrative found with uuid" . $uuid);
        }
        $this->em->remove($fragment);
        $this->em->flush();
    }
}