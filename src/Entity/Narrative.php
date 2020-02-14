<?php

namespace App\Entity;

use App\Entity\Composition\EntityDatableTrait;
use App\Entity\Composition\EntityUpdatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Abstraction\AbstractUniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="App\Repository\NarrativeRepository")
 */
class Narrative extends AbstractUniqueEntity
{
    use EntityDatableTrait, EntityUpdatableTrait;
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Narrative")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Narrative", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Narrative", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="narratives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fragment", mappedBy="narrative", orphanRemoval=true)
     */
    private $fragments;

    public function __construct()
    {
        parent::__construct();
        $this->fragments = new ArrayCollection();
    }
    
    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param mixed $lft
     */
    public function setLft($lft): void
    {
        $this->lft = $lft;
    }

    /**
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * @param mixed $lvl
     */
    public function setLvl($lvl): void
    {
        $this->lvl = $lvl;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param mixed $rgt
     */
    public function setRgt($rgt): void
    {
        $this->rgt = $rgt;
    }

    /**
     * @return mixed
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param mixed $root
     */
    public function setRoot($root): void
    {
        $this->root = $root;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children): void
    {
        $this->children = $children;
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

}
