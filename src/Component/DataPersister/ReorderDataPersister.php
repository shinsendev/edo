<?php

declare(strict_types=1);

namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Component\DTO\Model\ReorderDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Reorder\ReorderDTOPost;
use App\Component\Exception\EdoException;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentDataPersister
 * @package App\Component\DataPersister
 */
final class ReorderDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ValidatorInterface  */
    private $validator;

    /**
     * NarrativeDataPersister constructor.
     * @param ValidatorInterface $validator,
     * @param EntityManagerInterface $em
     */
    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $em
    )
    {
        $this->validator = $validator;
        $this->em = $em;
    }

    /**
     * @param $reorderDTO
     * @param array $context
     * @return bool
     */
    public function supports($reorderDTO, array $context = []): bool
    {
        return $reorderDTO instanceof ReorderDTO;
    }

    /**
     * @param $reorderDTO
     * @param array $context
     * @return object|void
     * @throws \Exception
     */
    public function persist($reorderDTO, array $context = [])
    {
        if (!$fragment = $this->em->getRepository(Fragment::class)->findOneByUuid($reorderDTO->getFragmentUuid())) {
            throw new EdoException('No fragment found to reorder');
        }

        $context = new DTOContext(new ReorderDTOPost(), $reorderDTO, $this->em, ['fragment' => $fragment]);

        return $context->proceed();
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }

}