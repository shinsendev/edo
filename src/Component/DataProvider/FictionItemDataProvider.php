<?php

declare(strict_types=1);

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FictionDTO;
use App\Component\Transformer\FictionDTOTransformer;
use App\Component\Transformer\TransformerConfig;
use App\Entity\Character;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FictionItemDataProvider
 * @package App\Component\DataProvider
 */
class FictionItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    /**
     * @param string $resourceClass
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     * @return FictionDTO|null
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []) :?FictionDTO
    {
        if (!$fiction = $this->em->getRepository(Fiction::class)->findOneByUuid($id)) {
            throw new NotFoundHttpException("Fiction not found for uuid " . $id);
        }

        $narratives = $this->em->getRepository(Narrative::class)->findByFiction($fiction);
        $characters = $this->em->getRepository(Character::class)->findByFiction($fiction);

        // convert narrative into Narrative DTO
        return FictionDTOTransformer::fromEntity(new TransformerConfig($fiction, ['narratives' => $narratives, 'characters' => $characters], $this->em));
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @param array $context
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return FictionDTO::class === $resourceClass;
    }

}