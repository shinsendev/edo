<?php

namespace App\Component\Transformer;

use App\Component\DTO\Model\DTOInterface;
use Doctrine\ORM\EntityManagerInterface;

interface TransformerInterface
{
    /**
     * @param TransformerConfig $config
     * @return mixed
     */
    static function fromEntity(TransformerConfig $config);

    /**
     * @param DTOInterface $dto
     * @param EntityManagerInterface $em
     * @return mixed
     */
    static function toEntity(DTOInterface $dto, EntityManagerInterface $em);
}