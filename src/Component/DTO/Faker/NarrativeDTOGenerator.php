<?php

declare(strict_types=1);

namespace App\Component\DTO\Faker;

use App\Component\DTO\NarrativeDTO;

class NarrativeDTOGenerator
{
    public static function generate()
    {
        $dto = new NarrativeDTO();
        $dto->setUuid('6153ca18-47a9-4b38-ae72-29e8340060cb');
        $dto->setContent('Narrative content generated for test');
        $dto->setFictionUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');
        $dto->setParentUuid('3d227809-a8d9-4851-8c70-a47f46802d32');

        return $dto;
    }
}