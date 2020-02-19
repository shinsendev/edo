<?php

declare(strict_types=1);

namespace App\Component\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Component\DTO\Composition\DatableTrait;
use App\Component\DTO\Composition\TreeableTrait;
use App\Component\DTO\Composition\UpdatableTrait;

/**
 * Class NarrativeDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="narrative"
 * )
 */
class NarrativeDTO extends AbstractDTO implements DTOInterface
{
    use DatableTrait, UpdatableTrait, TreeableTrait;

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
     * @var FragmentDTO[]
     */
    private $fragments;

    /**
     * @var string
     */
    private $fictionUuid;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return FragmentDTO[]
     */
    public function getFragments(): ?array
    {
        return $this->fragments;
    }

    /**
     * @param FragmentDTO[] $fragments
     */
    public function setFragments(array $fragments): void
    {
        $this->fragments = $fragments;
    }

    /**
     * @return string
     */
    public function getFictionUuid(): string
    {
        return $this->fictionUuid;
    }

    /**
     * @param string $fictionUuid
     */
    public function setFictionUuid(string $fictionUuid): void
    {
        $this->fictionUuid = $fictionUuid;
    }
}