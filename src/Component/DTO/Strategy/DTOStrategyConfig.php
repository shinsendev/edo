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

    /** @var array  */
    private $data;

    /**
     * DTOStrategyConfig constructor.
     * @param DTOInterface|null $dto
     * @param EntityManagerInterface|null $em
     * @param array $data
     */
    public function __construct(
        DTOInterface $dto = null,
        EntityManagerInterface $em = null,
        array $data = null
    )
    {
        $this->em = $em;
        $this->dto= $dto;
        $this->data = $data;
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
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}