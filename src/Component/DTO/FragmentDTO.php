<?php

namespace App\Component\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Ramsey\Uuid\Uuid;

/**
 * Class Fragment
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="fragment"
 * )
 */
class FragmentDTO
{
    /**
     * @var Uuid
     * @ApiProperty(identifier=true)
     */
    private $uuid;

    private $code;

    private $title;

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

}