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
     * @ORM\OneToMany(targetEntity="App\Entity\Narrative", mappedBy="fiction", orphanRemoval=true)
     */
    private $narratives;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Character", mappedBy="fiction", orphanRemoval=true)
     */
    private $characters;

    public function __construct()
    {
        $this->narratives = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    /**
     * @return Collection|Narrative[]
     */
    public function getNarratives(): Collection
    {
        return $this->narratives;
    }

    public function addNarrative(Narrative $narrative): self
    {
        if (!$this->narratives->contains($narrative)) {
            $this->narratives[] = $narrative;
            $narrative->setFiction($this);
        }

        return $this;
    }

    public function removeNarrative(Narrative $narrative): self
    {
        if ($this->narratives->contains($narrative)) {
            $this->narratives->removeElement($narrative);
            // set the owning side to null (unless already changed)
            if ($narrative->getFiction() === $this) {
                $narrative->setFiction(null);
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
