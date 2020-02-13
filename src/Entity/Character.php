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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $birthyear;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deathyear;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthyear(): ?int
    {
        return $this->birthyear;
    }

    public function setBirthyear(?int $birthyear): self
    {
        $this->birthyear = $birthyear;

        return $this;
    }

    public function getDeathyear(): ?int
    {
        return $this->deathyear;
    }

    public function setDeathyear(?int $deathyear): self
    {
        $this->deathyear = $deathyear;

        return $this;
    }

    public function getFiction(): ?Fiction
    {
        return $this->fiction;
    }

    public function setFiction(?Fiction $fiction): self
    {
        $this->fiction = $fiction;

        return $this;
    }
}
