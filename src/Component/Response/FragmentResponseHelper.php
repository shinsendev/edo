<?php

namespace App\Component\Response;

use App\Component\Date\DateConverter;
use App\Component\DTO\Model\FragmentDTO;
use App\Entity\Fragment;

class FragmentResponseHelper
{
    /**
     * @param FragmentDTO $dto
     * @param array $narrativeResponse
     * @return FragmentDTO
     */
    public static function createResponse(FragmentDTO $dto, array $narrativeResponse)
    {
        /** @var Fragment $fragment */
        $fragment = $narrativeResponse['fragment'];

        //from entity to DTO
        $dto->setCreatedAt(DateConverter::stringifyDatetime($fragment->getCreatedAt()));
        $dto->setUpdatedAt(DateConverter::stringifyDatetime($fragment->getUpdatedAt()));

        return $dto;
    }
}