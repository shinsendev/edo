<?php


namespace App\Component\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentDataPersister
 * @package App\Component\DataPersister
 */
final class NarrativeDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var EntityManagerInterface  */
    private $em;

    /**
     * FragmentItemDataProvider constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof NarrativeDTO;
    }

    public function persist($dto, array $context = [])
    {
        $narrative = NarrativeDTOTransformer::createEntityFromDTO($dto);

        dd('Narrative from persist');
        // call your persistence layer to save $data
        $fragment = $dto->toEntity();

        // persist $fragment
        $this->em->persist($fragment);
        $this->em->flush();

        //send back data with real fragment from database
        $fragment = $this->em->getRepository(Fragment::class)->findOneByUuid($dto->getUuid());
        $dto = $dto->fromEntity($fragment);
        return $dto;
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}