<?php


namespace App\Component\Narratable\Narrative;


use App\Component\Date\DateConverter;
use App\Component\DTO\Model\NarrativeDTO;
use App\Entity\Narrative;

class NarrativeResponseCreator
{
    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @return NarrativeDTO
     */
    public static function createResponse(NarrativeDTO $dto, Narrative $narrative)
    {
        //from entity to DTO
        $dto->setCreatedAt(DateConverter::stringifyDatetime($narrative->getCreatedAt()));
        $dto->setUpdatedAt(DateConverter::stringifyDatetime($narrative->getUpdatedAt()));

        return $dto;
    }
}