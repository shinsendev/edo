<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy;

use App\Component\DTO\Model\DTOInterface;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

class DTOStrategyConfig
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var DTOInterface  */
    private $dto;

    /** @var EntityInterface  */
    private $entity;

    public function __construct(DTOInterface $dto = null, EntityManagerInterface $em = null, EntityInterface $entity = null)
    {
        $this->em = $em;
        $this->dto= $dto;
        $this->entity = $entity;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @return DTOInterface
     */
    public function getDto(): DTOInterface
    {
        return $this->dto;
    }

    /**
     * @param DTOInterface $dto
     */
    public function setDto(DTOInterface $dto): void
    {
        $this->dto = $dto;
    }

    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @param EntityInterface $entity
     */
    public function setEntity(EntityInterface $entity): void
    {
        $this->entity = $entity;
    }
}