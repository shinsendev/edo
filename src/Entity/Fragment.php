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
     * @ORM\Column(type="string", length=1024)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Narrative", inversedBy="fragments")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $narrative;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
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
