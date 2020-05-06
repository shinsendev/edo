<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Component\DTO\Composition\DatableTrait;
use App\Component\DTO\Composition\UpdatableTrait;
use App\Entity\Character;
use App\Entity\Fragment;

/**
 * Class NarrativeDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="fiction"
 * )
 */
class FictionDTO extends AbstractDTO
{
    use DatableTrait, UpdatableTrait;

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
     * @var Fragment[]
     */
    private $fragments;

    //todo : to remove?
    /**
     * @var Fragment[]
     */
    private $origins;

    //todo : to remove?
    /**
     * @var Fragment[]
     */
    private $followings;

    /**
     * @var Character[]
     */
    private $characters;

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
     * @return Fragment[]
     */
    public function getFragments(): array
    {
        return $this->fragments;
    }

    /**
     * @param Fragment[] $fragments
     */
    public function setFragments(array $fragments): void
    {
        $this->fragments = $fragments;
    }

    /**
     * @return Fragment[]
     */
    public function getOrigins(): array
    {
        return $this->origins;
    }

    /**
     * @param Fragment[] $origins
     */
    public function setOrigins(array $origins): void
    {
        $this->origins = $origins;
    }

    /**
     * @return Fragment[]
     */
    public function getFollowings(): array
    {
        return $this->followings;
    }

    /**
     * @param Fragment[] $followings
     */
    public function setFollowings(array $followings): void
    {
        $this->followings = $followings;
    }

    /**
     * @return Character[]
     */
    public function getCharacters(): array
    {
        return $this->characters;
    }

    /**
     * @param Character[] $characters
     */
    public function setCharacters(array $characters): void
    {
        $this->characters = $characters;
    }

}