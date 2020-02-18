<?php

declare(strict_types=1);


namespace App\Component\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FictionDTO;
use App\Component\Transformer\FictionDTOTransformer;
use App\Repository\FictionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FictionItemDataProvider
 * @package App\Component\DataProvider
 */
class FictionItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $fictionRepository;

    public function __construct(FictionRepository $fictionRepository)
    {
        $this->fictionRepository = $fictionRepository;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []) :?FictionDTO
    {
        if (!$fiction = $this->fictionRepository->findOneByUuid($id)) {
            throw new NotFoundHttpException("Fiction not found for uuid " . $id);
        }

        // convert narrative into Narrative DTO
        return FictionDTOTransformer::fromEntity($fiction);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return FictionDTO::class === $resourceClass;
    }

}