<?php

declare(strict_types=1);


namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class ReorderDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="reorder",
 *     collectionOperations={
 *         "get"={
 *             "controller"= NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *          "post"
 *  },
 *     itemOperations={
 *         "get"={
 *             "controller"= NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         }
 *     }
 * )
 */
class ReorderDTO extends AbstractDTO
{
    /**
     * @ApiProperty(identifier=true)
     */
    private $uuid;

    /**
     * @var string
     */
    private $sourceUuid;

    /**
     * @var string
     */
    private $sourceType;

    /**
     * @var ?string
     */
    private $parentUuid;

    /**
     * @var integer
     */
    private $position;

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
    public function getSourceUuid(): string
    {
        return $this->sourceUuid;
    }

    /**
     * @param string $sourceUuid
     */
    public function setSourceUuid(string $sourceUuid): void
    {
        $this->sourceUuid = $sourceUuid;
    }

    /**
     * @return string
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * @param string $sourceType
     */
    public function setSourceType(string $sourceType): void
    {
        $this->sourceType = $sourceType;
    }

    /**
     * @return mixed
     */
    public function getParentUuid()
    {
        return $this->parentUuid;
    }

    /**
     * @param mixed $parentUuid
     */
    public function setParentUuid($parentUuid): void
    {
        $this->parentUuid = $parentUuid;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

}