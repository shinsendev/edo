<?php

declare(strict_types=1);

namespace App\Component\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FictionDTO;
use App\Component\Transformer\FictionDTOTransformer;
use App\Repository\CharacterRepository;
use App\Repository\FictionRepository;
use App\Repository\NarrativeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FictionItemDataProvider
 * @package App\Component\DataProvider
 */
class FictionItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var FictionRepository  */
    private $fictionRepository;

    /** @var NarrativeRepository  */
    private $narrativeRepository;

    /** @var CharacterRepository  */
    private $characterRepository;

    public function __construct(
        FictionRepository $fictionRepository,
        NarrativeRepository $narrativeRepository,
        CharacterRepository $characterRepository
    )
    {
        $this->fictionRepository = $fictionRepository;
        $this->narrativeRepository = $narrativeRepository;
        $this->characterRepository = $characterRepository;
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
        if (!$fiction = $this->fictionRepository->findOneByUuid($id)) {
            throw new NotFoundHttpException("Fiction not found for uuid " . $id);
        }

        $narratives = $this->narrativeRepository->findByFiction($fiction);
        $characters = $this->characterRepository->findByFiction($fiction);

        // convert narrative into Narrative DTO
        return FictionDTOTransformer::fromEntity($fiction, [
                'narratives' => $narratives,
                'characters' => $characters
            ]);
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