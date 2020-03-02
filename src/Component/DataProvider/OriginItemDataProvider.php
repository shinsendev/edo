<?php

declare(strict_types=1);


namespace App\Component\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\OriginDTO;
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
     * @return object|void|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        if (!$narrative = $this->em->getRepository(Narrative::class)->findOneOriginByNarrativeUuid($id)) {
            throw new NotFoundHttpException("No origin narrative found for uuid " . $id);
        }



        dd($narrative);
        // TODO : create an list of all narratives // how to limit?
        // TODO: Implement getItem() method.
    }

}