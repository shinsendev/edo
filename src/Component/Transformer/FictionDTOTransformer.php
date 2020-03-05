<?php

declare(strict_types=1);


namespace App\Component\Transformer;


use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\FictionDTO;
use App\Entity\Fragment;
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
        $nested = $config->getNested();
        $em = $config->getEm();

        $narrativesDTO = [];
        foreach ($nested['narratives'] as $narrative) {
            $nestedConfig = new TransformerConfig(
                $narrative, ['fragments' => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid())],
                $em,
                ['nested' => true] // we don't want all the fragments of the narrative
            );

            $narrativesDTO[]= NarrativeDTOTransformer::fromEntity($nestedConfig); // needs fragment
        }

        $originsDTO = [];
        foreach ($nested['origins'] as $narrative) {
            $nestedConfig = new TransformerConfig(
                $narrative, ['fragments' => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid())],
                $em,
                ['nested' => true] // we don't want all the fragments of the narrative
            );

             $originsDTO[]= NarrativeDTOTransformer::fromEntity($nestedConfig); // needs fragment
        }

        $followingsDTO = [];
        foreach ($nested['followings'] as $narrative) {
            $nestedConfig = new TransformerConfig(
                $narrative, ['fragments' => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid())],
                $em,
                ['nested' => true] // we don't want all the fragments of the narrative
            );

            $followingsDTO[] = NarrativeDTOTransformer::fromEntity($nestedConfig); // needs fragment
        }

        $charactersDTO = [];
        foreach ($nested['characters'] as $character) {
            $charactersDTO[] = CharacterDTOTransformer::fromEntity(new TransformerConfig($character));
        }

        $fictionDTO->setNarratives($narrativesDTO);
        $fictionDTO->setOrigins($originsDTO);
        $fictionDTO->setFollowings($followingsDTO);
        $fictionDTO->setCharacters($charactersDTO);

        return $fictionDTO;
    }

}