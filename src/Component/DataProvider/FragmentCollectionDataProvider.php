<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Repository\FragmentRepository;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class FragmentCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var FragmentRepository  */
    private $fragmentRepository;

    public function __construct(FragmentRepository $fragmentRepository)
    {
        $this->fragmentRepository = $fragmentRepository;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return FragmentDTO::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $fragments = $this->fragmentRepository->findAllDistinctFragments(10);

        foreach ($fragments as $fragment) {
            yield (new FragmentDTO())->fromEntity($fragment);
        }
    }
}