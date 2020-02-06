<?php

declare(strict_types=1);

namespace App\Tests\Helper;


use App\Component\DTO\NarrativeDTO;
use App\Entity\Fragment;
use App\Entity\Narrative;

/**
 * Class NarrativeTestGenerator
 * @package App\Tests\Helper
 */
class NarrativeTestGenerator
{
    /**
     * @return NarrativeDTO
     */
    public static function generateDTO()
    {
        $dto = new NarrativeDTO();
        $dto->setUuid('6153ca18-47a9-4b38-ae72-29e8340060cb');
        $dto->setTitle('Narrative title generated');
        $dto->setContent('Narrative content generated for test');

        return $dto;
    }

    /**
     * @return Narrative
     * @throws \Exception
     */
    public static function generateEntity()
    {
        $narrative = new Narrative();
        $narrative->setUuid('76144aa9-407d-41d6-b970-13ead25c4770');

        return $narrative;
    }
}