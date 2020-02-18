<?php


namespace App\Component\Transformer;


use App\Component\DTO\DTOInterface;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

interface TransformerInterface
{
    static function fromEntity(EntityInterface $entity, array $nested);

    static function toEntity(DTOInterface $dto, EntityManagerInterface $em);
}