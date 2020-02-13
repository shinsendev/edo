<?php

declare(strict_types=1);


namespace App\Component\Generator;


use App\Component\DTO\NarrativeDTO;

class NarrativeDTOGenerator
{
    /**
     * @return NarrativeDTO
     */
    public static function generate()
    {
        $dto = new NarrativeDTO();
        $dto->setUuid('6153ca18-47a9-4b38-ae72-29e8340060cb');
        $dto->setTitle('Narrative title generated');
        $dto->setContent('Narrative content generated for test');

        return $dto;
    }
}