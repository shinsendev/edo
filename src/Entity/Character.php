<?php

namespace App\Entity;

use App\Entity\Abstraction\AbstractUniqueEntity;
use App\Entity\Composition\EntityDatableTrait;
use App\Entity\Composition\EntityUpdatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 */
class Character extends AbstractUniqueEntity
{
    use EntityDatableTrait, EntityUpdatableTrait;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $birthYear;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deathYear;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

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

    /**
     * @return mixed
     */
    public function getFiction()
    {
        return $this->fiction;
    }

    /**
     * @param mixed $fiction
     */
    public function setFiction($fiction): void
    {
        $this->fiction = $fiction;
    }
}
