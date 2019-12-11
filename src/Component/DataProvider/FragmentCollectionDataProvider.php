<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO as FragmentDTO;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class FragmentCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return FragmentDTO::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        // create logic for getting the data from fragment, etc.
        //todo : get a collection of fragments and transform them into DTO

        // getSource
        $fragments = $this->em->getRepository(Fragment::class)->findBy([], [], 10);

        foreach ($fragments as $fragment) {
            $dto = new FragmentDTO();
            $dto->setTitle($fragment->getTitle());
            $dto->setCode($fragment->getCode());
            $dto->setContent($fragment->getContent());

            // keep the uuid of the data
            $uuid = Uuid::uuid4();
            $uuid->unserialize($fragment->getUuid());
            $dto->setUuid($uuid);

            yield $dto;

        }
    }
}