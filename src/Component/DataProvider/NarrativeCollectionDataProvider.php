<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Repository\FragmentRepository;
use App\Repository\NarrativeRepository;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class NarrativeCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var FragmentRepository  */
    private $fragmentRepository;

    /** @var NarrativeRepository  */
    private $narrativeRepository;

    public function __construct(FragmentRepository $fragmentRepository, NarrativeRepository $narrativeRepository)
    {
        $this->fragmentRepository = $fragmentRepository;
        $this->narrativeRepository = $narrativeRepository;
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
        $narratives = $this->narrativeRepository->findLastNarratives(3);

        foreach ($narratives as $narrative) {
            yield $narrativeDTO = NarrativeDTOTransformer::fromEntity($narrative, [
                // we only keep the last fragment to set the title and the content
                "fragments" => $this->fragmentRepository->findNarrativeLastFragments($narrative->getUuid() ,10)
            ]);
        }
    }
}