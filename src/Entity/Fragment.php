<?php

namespace App\Entity;

use App\Entity\Composition\EntityDatableTrait;
use App\Entity\Composition\EntityUpdatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Abstraction\AbstractUniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FragmentRepository")
 */
class Fragment extends AbstractUniqueEntity
{
    use EntityDatableTrait, EntityUpdatableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fiction", inversedBy="fragments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Version", mappedBy="fragment", orphanRemoval=true)
     */
    private $versions;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Position", mappedBy="fragment", orphanRemoval=true)
     */
    private $position;

    public function __construct()
    {
        parent::__construct();
        $this->versions = new ArrayCollection();
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
     * @return Collection|Version[]
     */
    public function getVersions(): Collection
    {
        return $this->versions;
    }

    public function addVersion(Version $version): self
    {
        if (!$this->versions->contains($version)) {
            $this->versions[] = $version;
            $version->setVersion($this);
        }

        return $this;
    }

    public function removeVersion(Version $version): self
    {
        if ($this->versions->contains($version)) {
            $this->versions->removeElement($version);
            // set the owning side to null (unless already changed)
            if ($version->getFragment() === $this) {
                $version->setFragment(null);
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
