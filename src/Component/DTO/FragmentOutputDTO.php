<?php

namespace App\Component\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Entity\Fragment;
use Ramsey\Uuid\Uuid;

/**
 * Class Fragment
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="fragment"
 * )
 */
class FragmentOutputDTO
{
    /**
     * @var Uuid
     * @ApiProperty(identifier=true)
     */
    private $uuid;

    /**
     * @var string
     */
    private $code;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
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
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @param Fragment $fragment
     * @return FragmentOutputDTO
     * @throws \Exception
     */
    public function fromEntity(Fragment $fragment):FragmentOutputDTO
    {
        $this->setTitle($fragment->getTitle());
        $this->setCode($fragment->getCode());
        $this->setContent($fragment->getContent());

        // keep the uuid of the data
        $uuid = Uuid::uuid4();
        $uuid->unserialize($fragment->getUuid());
        $this->setUuid($uuid);

        return $this;
    }
}