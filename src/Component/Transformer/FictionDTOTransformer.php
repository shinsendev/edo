<?php

declare(strict_types=1);


namespace App\Component\Transformer;


use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\FictionDTO;
use App\Entity\Position;
use App\Entity\Version;
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

        $fictionsDTO = [];
        foreach ($nested['fragments'] as $fragment) {

            /** @var Position $position */
            $position = $em->getRepository(Position::class)->findOneByFragment($fragment);
            $nestedConfig = new TransformerConfig(
                $fragment, ['versions' => $em->getRepository(Version::class)->findFragmentLastVersions($fragment->getUuid())],
                $em,
                [
                    'nested' => true, // we don't want all the fragments of the narrative
                    'position' => $position
                ]
            );
            $fictionsDTO[]= FragmentDTOTransformer::fromEntity($nestedConfig); // needs fragment
        }

        $charactersDTO = [];
        foreach ($nested['characters'] as $character) {
            $charactersDTO[] = CharacterDTOTransformer::fromEntity(new TransformerConfig($character));
        }

        $fictionDTO->setFragments($fictionsDTO);
        $fictionDTO->setCharacters($charactersDTO);

        return $fictionDTO;
    }

}