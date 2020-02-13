<?php

namespace App\Entity;

use App\Entity\Abstraction\AbstractUniqueEntity;
use App\Entity\Composition\EntityDatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FragmentRepository")
 */
class Fragment extends AbstractUniqueEntity
{
    use EntityDatableTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="Qualification", mappedBy="fragment", cascade={"remove"})
     */
    private $qualifications;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Narrative", inversedBy="fragments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $narrative;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }

    /**
     * @param mixed $qualifications
     */
    public function setQualifications($qualifications): void
    {
        $this->qualifications = $qualifications;
    }

    public function getNarrative(): ?Narrative
    {
        return $this->narrative;
    }

    public function setNarrative(?Narrative $narrative): self
    {
        $this->narrative = $narrative;

        return $this;
    }

}
