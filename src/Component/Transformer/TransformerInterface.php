<?php


namespace App\Component\Transformer;


use App\Component\DTO\DTOInterface;

interface TransformerInterface
{
    static function fromArray(array $source);

    static function toEntity(DTOInterface $dto);
}