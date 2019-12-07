<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO as FragmentDTO;
use Ramsey\Uuid\Uuid;

final class FragmentCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return FragmentDTO::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        // create logic for getting the data from fragment, etc.
        //todo : get a collection of fragments and transform them into DTO

        // getSource
        // fromSourceToDTO
        // expose data

        $uuid1 = Uuid::uuid4();
        $dto1 = new FragmentDTO();
        $dto1->setUuid($uuid1);
        $dto1->setContent('Hellso');
        $uuid2 = Uuid::uuid4();
        $dto2 = new FragmentDTO();
        $dto2->setContent('Bye');
        $dto2->setUuid($uuid2);

        yield $dto1;
        yield $dto2;
    }
}