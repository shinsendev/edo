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
    private $narrativeUuid;

    /** @var FragmentDTO[] */
    private $fragments;

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