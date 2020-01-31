<?php

namespace App\Component\DTO;

use ApiPlatform\Core\Annotation\ApiProperty;
use App\Component\DTO\Composition\DatableTrait;
use App\Entity\Fragment;
use Ramsey\Uuid\Uuid;

/**
 * Class Fragment
 * @package App\Component\DTO
 */
class FragmentDTO
{
    use DatableTrait;

    /**
     * @ApiProperty(identifier=true)
     */
    private $uuid;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

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
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @param Fragment $fragment
     * @return FragmentDTO
     * @throws \Exception
     */
    public function fromEntity(Fragment $fragment):FragmentDTO
    {
        $this->setTitle($fragment->getTitle());
        $this->setContent($fragment->getContent());

        // keep the uuid of the data
        $uuid = Uuid::uuid4();
        $uuid->unserialize($fragment->getUuid());
        $this->setUuid($uuid);

        return $this;
    }

    /**
     * @return Fragment
     * @throws \Exception
     */
    public function toEntity(): Fragment
    {
        $fragment = new Fragment();

        $fragment->setTitle($this->getTitle());
        $fragment->setContent($this->getContent());
        $fragment->setUuid($this->getUuid());

        return $fragment;
    }
}