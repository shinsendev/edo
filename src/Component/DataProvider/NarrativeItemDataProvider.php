<?php


namespace App\Component\DataProvider;


use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\NarrativeDTOGetItem;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class NarrativeItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var EntityManagerInterface  */
    protected $em;

    /**
     * NarrativeItemDataProvider constructor.
     * @param EntityManagerInterface $em
     */
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
     * @param array|int|string $id
     * @param string|null $operationName
     * @param array $context
     *
     * @return FragmentDTO|null
     * @throws \Exception
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?NarrativeDTO
    {
        if (!$narrative = $this->em->getRepository(Narrative::class)->findOneByUuid($id)) {
            throw new NotFoundHttpException("Narrative not found for uuid " . $id);
        }

        /** @var NarrativeDTO */
        return (new DTOContext(new NarrativeDTOGetItem(), null, $this->em, $narrative))->proceed();
    }

}