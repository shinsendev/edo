<?php

namespace App\Entity;

use App\Entity\Composition\EntityDatableTrait;
use App\Entity\Composition\EntityUpdatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Abstraction\AbstractUniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NarrativeRepository")
 */
class Narrative extends AbstractUniqueEntity
{
    use EntityDatableTrait, EntityUpdatableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="narratives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fragment", mappedBy="narrative", orphanRemoval=true)
     */
    private $fragments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Position", mappedBy="narrative", orphanRemoval=true)
     */
    private $position;

    public function __construct()
    {
        parent::__construct();
        $this->fragments = new ArrayCollection();
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
            $fragment->setNarrative($this);
        }

        return $this;
    }

    public function removeFragment(Fragment $fragment): self
    {
        if ($this->fragments->contains($fragment)) {
            $this->fragments->removeElement($fragment);
            // set the owning side to null (unless already changed)
            if ($fragment->getNarrative() === $this) {
                $fragment->setNarrative(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

}
