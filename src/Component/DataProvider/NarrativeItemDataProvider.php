<?php


namespace App\Component\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Repository\FragmentRepository;
use App\Repository\NarrativeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class NarrativeItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var FragmentRepository  */
    private $fragmentRepository;

    /** @var NarrativeRepository  */
    private $narrativeRepository;

    /**
     * NarrativeItemDataProvider constructor.
     * @param FragmentRepository $fragmentRepository
     * @param NarrativeRepository $narrativeRepository
     */
    public function __construct(FragmentRepository $fragmentRepository, NarrativeRepository $narrativeRepository)
    {
        $this->fragmentRepository = $fragmentRepository;
        $this->narrativeRepository = $narrativeRepository;
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
        if (!$narrative = $this->narrativeRepository->findOneByUuid($id)) {
            throw new NotFoundHttpException("Narrative not found for uuid " . $id);
        }

        // convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity($narrative, [
            "fragments" => $this->fragmentRepository->findNarrativeLastFragments($id ,10)
        ]);
    }

}