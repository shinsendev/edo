<?php

declare(strict_types=1);

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\GetItem\FragmentDTOGetItemFromCollection;
use App\Component\DTO\Strategy\Origin\GetItem\NarrativeDTOGetItem;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NarrativeItemDataProvider
 * @package App\Component\DataProvider
 */
class NarrativeItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    /**
     * NarrativeItemDataProvider constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return NarrativeDTO::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     * @return \Generator|object|null
     * @throws \App\Component\Exception\EdoException
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // check if it is a narrative
        if (!$fragment = $this->em->getRepository(Fragment::class)->findOneOriginByNarrativeUuid($id)) {
            throw new NotFoundHttpException("No origin narrative found for uuid " . $id);
        }

        // get a limit number of narratives with the same parent if
        $fragments = $this->em->getRepository(Fragment::class)->findOriginNarratives($fragment, 100);

        // first we create a list of narratives DTO, specialy for using the narratives uuid for hierarchy and not the position
        /** @var FragmentDTO[] $fragmentsDTO */
        $fragmentsDTO = [];

        /** @var Fragment $fragment */
        foreach ($fragments as $fragment) {
            /** @var FragmentDTO */
            $fragmentsDTO[] = (new DTOContext(new FragmentDTOGetItemFromCollection(), null, $this->em, ['fragment' => $fragment]))->proceed();
        }

        // then we create the payload with hierarchy
        return (new DTOContext(new NarrativeDTOGetItem(), null, $this->em, ['fragmentsDTO' => $fragmentsDTO]))->proceed();
    }

}