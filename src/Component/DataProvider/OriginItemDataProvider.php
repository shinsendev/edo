<?php

declare(strict_types=1);

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Model\OriginDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\GetItem\NarrativeDTOGetItemFromCollection;
use App\Component\DTO\Strategy\Origin\GetItem\OriginDTOGetItem;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OriginItemDataProvider
 * @package App\Component\DataProvider
 */
class OriginItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    /**
     * OriginItemDataProvider constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return OriginDTO::class === $resourceClass;
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
        if (!$narrative = $this->em->getRepository(Narrative::class)->findOneOriginByNarrativeUuid($id)) {
            throw new NotFoundHttpException("No origin narrative found for uuid " . $id);
        }

        // get a limit number of narratives with the same parent if
        $narratives = $this->em->getRepository(Narrative::class)->findOriginNarratives($narrative, 100);

        // first we create a list of narratives DTO, specialy for using the narratives uuid for hierarchy and not the position
        /** @var NarrativeDTO[] $narrativesDTO */
        $narrativesDTO = [];

        /** @var Narrative $narrative */
        foreach ($narratives as $narrative) {

            /** @var NarrativeDTO */
            $narrativesDTO[] = (new DTOContext(new NarrativeDTOGetItemFromCollection(), null, $this->em, ['narrative' => $narrative]))->proceed();
        }

        // then we create the payload with hierarchy
        $rsl = (new DTOContext(new OriginDTOGetItem(), null, $this->em, ['narrativesDTO' => $narrativesDTO]))->proceed();

        dd($rsl);


    }

}