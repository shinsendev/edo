<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Component\Transformer\TransformerConfig;
use App\Entity\Fiction;
use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Repository\FragmentRepository;
use App\Repository\NarrativeRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class NarrativeCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
        //todo: replace by dynamic fiction
        $fiction = $this->em->getRepository(Fiction::class)->findAll();
        $narratives = $this->em->getRepository(Narrative::class)->findLastNarratives($fiction[0]);

        foreach ($narratives as $narrative) {
            $config = new TransformerConfig(
                $narrative,
                // we only keep the last fragment to set the title and the content
                ["fragments" => $this->em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid() ,10)],
                $this->em
            );
            yield NarrativeDTOTransformer::fromEntity($config);
        }
    }
}