<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
/**
 * Class NarrativeDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="narrative",
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 */
class NarrativeDTO extends AbstractDTO
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    private $originUuid;

    /** @var FragmentDTO[] */
    private $fragments;

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
    public function getFragments(): array
    {
        return $this->fragments;
    }

    /**
     * @param NarrativeDTO[] $fragments
     */
    public function setFragments(array $fragments): void
    {
        $this->fragments = $fragments;
    }

}