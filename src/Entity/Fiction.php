<?php

namespace App\Entity;

use App\Entity\Abstraction\AbstractUniqueEntity;
use App\Entity\Composition\EntityDatableTrait;
use App\Entity\Composition\EntityUpdatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FictionRepository")
 */
class Fiction extends AbstractUniqueEntity
{
    use EntityDatableTrait, EntityUpdatableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fragment", mappedBy="fiction", orphanRemoval=true)
     */
    private $fragments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Character", mappedBy="fiction", orphanRemoval=true)
     */
    private $characters;

    public function __construct()
    {
        parent::__construct();
        $this->fragments = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    /**
     * @return Collection|Fragment[]
     */
    public function getFragments(): Collection
    {
        return $this->fragments;
    }

    public function addFragment(Fragment $fragment): self
    {
        if (!$this->fragments->contains($fragment)) {
            $this->fragments[] = $fragment;
            $fragment->setFiction($this);
        }

        return $this;
    }

    public function removeFragment(Fragment $fragment): self
    {
        if ($this->fragments->contains($fragment)) {
            $this->fragments->removeElement($fragment);
            // set the owning side to null (unless already changed)
            if ($fragment->getFiction() === $this) {
                $fragment->setFiction(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setFiction($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->contains($character)) {
            $this->characters->removeElement($character);
            // set the owning side to null (unless already changed)
            if ($character->getFiction() === $this) {
                $character->setFiction(null);
            }
        }

        return $this;
    }
}
