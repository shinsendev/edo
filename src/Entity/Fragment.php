<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Helper\BaseTrait;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FragmentRepository")
 */
class Fragment
{
    use BaseTrait;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;


    public function getCode(): ?string
    {
        return $this->code;
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

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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
}
