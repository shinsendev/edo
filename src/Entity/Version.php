<?php

namespace App\Entity;

use App\Entity\Abstraction\AbstractUniqueEntity;
use App\Entity\Composition\EntityDatableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VersionRepository")
 */
class Version extends AbstractUniqueEntity
{
    use EntityDatableTrait;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fragment", inversedBy="versions")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $fragment;

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
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param mixed $fragment
     */
    public function setFragment($fragment): void
    {
        $this->fragment = $fragment;
    }

}
