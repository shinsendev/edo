<?php

namespace App\Component\Response;

use App\Component\Date\DateConverter;
use App\Component\DTO\Model\NarrativeDTO;
use App\Entity\Narrative;

class NarrativeResponseHelper
{
    /**
     * @param NarrativeDTO $dto
     * @param array $narrativeResponse
     * @return NarrativeDTO
     */
    public static function createResponse(NarrativeDTO $dto, array $narrativeResponse)
    {
        /** @var Narrative $narrative */
        $narrative = $narrativeResponse['narrative'];

        //from entity to DTO
        $dto->setCreatedAt(DateConverter::stringifyDatetime($narrative->getCreatedAt()));
        $dto->setUpdatedAt(DateConverter::stringifyDatetime($narrative->getUpdatedAt()));

        return $dto;
    }
}