<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
/**
 * Class OriginDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="origin",
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 */
class OriginDTO extends AbstractDTO
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    private $originUuid;

    /** @var NarrativeDTO[] */
    private $narratives;

    /**
     * @return string
     */
    public function getOriginUuid(): string
    {
        return $this->originUuid;
    }

    /**
     * @param string $originUuid
     */
    public function setOriginUuid(string $originUuid): void
    {
        $this->originUuid = $originUuid;
    }

    /**
     * @return NarrativeDTO[]
     */
    public function getNarratives(): array
    {
        return $this->narratives;
    }

    /**
     * @param NarrativeDTO[] $narratives
     */
    public function setNarratives(array $narratives): void
    {
        $this->narratives = $narratives;
    }

}