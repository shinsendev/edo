<?php


namespace App\Component\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Repository\NarrativeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class NarrativeItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var NarrativeRepository  */
    private $repository;

    /**
     * FragmentItemDataProvider constructor.
     * @param NarrativeRepository $repository
     */
    public function __construct(NarrativeRepository $repository)
    {
        $this->repository = $repository;
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
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     *
     * @return FragmentDTO|null
     * @throws \Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?NarrativeDTO
    {
        if (!$narrative = $this->repository->findOneByUuid($id)) {
            throw new NotFoundHttpException("Item not found for uuid " . $id);
        }

        // convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity($narrative, [
            "fragments" => $this->repository->findLastFragments($id ,10)
        ]);
    }

}