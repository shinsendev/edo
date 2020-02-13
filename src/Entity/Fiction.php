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

    public function __construct()
    {
        $this->narratives = new ArrayCollection();
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
}
