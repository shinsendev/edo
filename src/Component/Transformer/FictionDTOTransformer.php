<?php

declare(strict_types=1);


namespace App\Component\Transformer;


use App\Component\Date\DateTimeHelper;
use App\Component\DTO\DTOInterface;
use App\Component\DTO\FictionDTO;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

class FictionDTOTransformer extends AbstractTransformer implements TransformerInterface
{

    static function toEntity(DTOInterface $dto, EntityManagerInterface $em)
    {
        // TODO: Implement toEntity() method.
    }

    static function fromEntity(EntityInterface $entity, array $nested = [])
    {
        $fictionDTO = new FictionDTO();
        $fictionDTO->setUuid($entity->getUuid());
        $fictionDTO->setTitle($entity->getTitle());
        $fictionDTO->setContent(''); // todo: get description narrative
        $fictionDTO->setCreatedAt(DateTimeHelper::stringify($entity->getCreatedAt()));
        $fictionDTO->setUpdatedAt(DateTimeHelper::stringify($entity->getUpdatedAt()));

        // manage embedded
        $narrativesDTO = [];

        foreach ($nested['narratives'] as $narrative) {
            $narrativesDTO[]= NarrativeDTOTransformer::fromEntity($narrative,
                ['fragments' => $narrative->getFragments()]
            ); // needs fragment
        }

        $fictionDTO->setNarratives($narrativesDTO);
        $fictionDTO->setOrigins([]);
        $fictionDTO->setFollowings([]);
        $fictionDTO->setCharacters([]);


        return $fictionDTO;
    }

}