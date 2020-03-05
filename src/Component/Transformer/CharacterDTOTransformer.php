<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\CharacterDTO;
use App\Component\DTO\Model\AbstractDTO;
use App\Component\DTO\Model\DTOInterface;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CharacterDTOTransformer
 * @package App\Component\Transformer
 */
class CharacterDTOTransformer implements TransformerInterface
{
    static function fromEntity(TransformerConfig $config)
    {
        /** @var Character $character */
        $character = $config->getSource();

        $characterDTO = new CharacterDTO();
        $characterDTO->setCreatedAt(DateTimeHelper::stringify($character->getCreatedAt()));
        $characterDTO->setUpdatedAt(DateTimeHelper::stringify($character->getUpdatedAt()));
        $characterDTO->setFirstName($character->getFirstName());
        $characterDTO->setLastName($character->getLastName());
        $characterDTO->setBirthYear($character->getBirthYear());
        $characterDTO->setDeathYear($character->getDeathYear());
        $characterDTO->setUuid($character->getUuid());

        return $characterDTO;
    }

    static function toEntity(DTOInterface $dto, EntityManagerInterface $em)
    {
        // TODO: Implement toEntity() method.
    }

}