<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentOutputDTO as FragmentOutputDTO;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class FragmentCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return FragmentOutputDTO::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        $fragments = $this->em->getRepository(Fragment::class)->findBy([], [], 10);

        foreach ($fragments as $fragment) {
            yield (new FragmentOutputDTO())->fromEntity($fragment);
        }
    }
}