<?php

declare(strict_types=1);

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FictionDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Fiction\FictionDTOGetItem;
use App\Entity\Fiction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FictionItemDataProvider
 * @package App\Component\DataProvider
 */
class FictionItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    /**
     * @param string $resourceClass
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     * @return FictionDTO|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []) :?FictionDTO
    {
        if (!$fiction = $this->em->getRepository(Fiction::class)->findOneByUuid($id)) {
            throw new NotFoundHttpException("Fiction not found for uuid " . $id);
        }

        /** @var FictionDTO  */
        return (new DTOContext(new FictionDTOGetItem(), null, $this->em, $fiction))->proceed();
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return FictionDTO::class === $resourceClass;
    }

}