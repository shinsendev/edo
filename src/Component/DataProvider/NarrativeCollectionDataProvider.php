<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Repository\FragmentRepository;
use App\Repository\NarrativeRepository;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class NarrativeCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var NarrativeRepository  */
    private $repository;

    public function __construct(NarrativeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return NarrativeDTO::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @return \Generator
     * @throws \Exception
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $fragments = $this->repository->findAllNarrativesLastFragments(10);

        foreach ($fragments as $fragment) {
            yield (new NarrativeDTO())->fromEntity($fragment);
        }
    }
}