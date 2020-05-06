<?php

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\GetItem\FragmentDTOGetItem;
use App\Component\DTO\Strategy\Narrative\GetItem\NarrativeDTOGetItem;
use App\Entity\Fiction;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

/**
 * todo: do we need this provider? + do we need fragments for this narrative? When are we supposed to use get Narratives collections?
 *
 * Class FragmentCollectionDataProvider
 * @package App\Component\DataProvider
 */
final class FragmentCollectionDataProvider implements CollectionDataProviderInterface
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
     * @return \Generator
     * @throws \Exception
     */
    public function getCollection(string $resourceClass, string $operationName = null): \Generator
    {
        //todo: replace by dynamic fiction
        /** @var Fiction[] $fiction */
        $fiction = $this->em->getRepository(Fiction::class)->findAll();
        $fragments = $this->em->getRepository(Fragment::class)->findLastNarratives($fiction[0]);

        foreach ($fragments as $fragment) {
            /** @var FragmentDTO */
            yield (new DTOContext(new FragmentDTOGetItem(), null, $this->em, ['fragment' => $fragment]))->proceed();
        }
    }
}