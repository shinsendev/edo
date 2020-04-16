<?php

declare(strict_types=1);


namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\NotFoundController;

/**
 * Class ReorderDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="reorder",
 *     collectionOperations={
 *         "get"={
 *             "controller"= NotFoundController::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *          "post"
 *  },
 *     itemOperations={
 *         "get"={
 *             "controller"= NotFoundController::class,
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
    private $narrativeUuid;

    /**
     * @var ?string
     */
    private $parentUuid;

    /**
     * @var integer
     */
    private $position;

    /**
     * @return string
     */
    public function getNarrativeUuid(): string
    {
        return $this->narrativeUuid;
    }

    /**
     * @param string $narrativeUuid
     */
    public function setNarrativeUuid(string $narrativeUuid): void
    {
        $this->narrativeUuid = $narrativeUuid;
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