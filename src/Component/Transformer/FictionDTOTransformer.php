<?php

declare(strict_types=1);


namespace App\Component\Transformer;


use App\Component\Date\DateTimeHelper;
use App\Component\DTO\DTOInterface;
use App\Component\DTO\FictionDTO;
use App\Entity\EntityInterface;
use App\Entity\Fragment;
use App\Repository\FragmentRepository;
use Doctrine\ORM\EntityManagerInterface;

class FictionDTOTransformer extends AbstractTransformer implements TransformerInterface
{

    static function toEntity(DTOInterface $dto, EntityManagerInterface $em)
    {
        // TODO: Implement toEntity() method.
    }

    static function fromEntity(TransformerConfig $config)
    {
        $fictionDTO = new FictionDTO();
        $entity = $config->getSource();
        $fictionDTO->setUuid($entity->getUuid());
        $fictionDTO->setTitle($entity->getTitle());
        $fictionDTO->setContent(''); // todo: get description narrative
        $fictionDTO->setCreatedAt(DateTimeHelper::stringify($entity->getCreatedAt()));
        $fictionDTO->setUpdatedAt(DateTimeHelper::stringify($entity->getUpdatedAt()));

        // manage embedded
        $narrativesDTO = [];
        $nested = $config->getNested();
        $em = $config->getEm();

        foreach ($nested['narratives'] as $narrative) {
            $nestedConfig = new TransformerConfig($narrative, [
                'fragments' => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid())
            ], $em);

            $narrativesDTO[]= NarrativeDTOTransformer::fromEntity($nestedConfig); // needs fragment
        }

        $fictionDTO->setNarratives($narrativesDTO);
        $fictionDTO->setOrigins([]);
        $fictionDTO->setFollowings([]);
        $fictionDTO->setCharacters([]);

        return $fictionDTO;
    }

}