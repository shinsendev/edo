<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use App\Component\DTO\Model\AbstractDTO;
use App\Component\DTO\Composition\DatableTrait;
use App\Component\DTO\Composition\UpdatableTrait;

/**
 * Class CharacterDTO
 * @package App\Component\DTO
 */
class CharacterDTO extends AbstractDTO
{
    use DatableTrait, UpdatableTrait;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var int
     */
    private $birthYear;

    /**
     * @var int
     */
    private $deathYear;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getBirthYear()
    {
        return $this->birthYear;
    }

    /**
     * @param mixed $birthYear
     */
    public function setBirthYear($birthYear): void
    {
        $this->birthYear = $birthYear;
    }

    /**
     * @return mixed
     */
    public function getDeathYear()
    {
        return $this->deathYear;
    }

    /**
     * @param mixed $deathYear
     */
    public function setDeathYear($deathYear): void
    {
        $this->deathYear = $deathYear;
    }
}