<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use App\Component\DTO\Composition\DatableTrait;
use App\Component\DTO\Composition\TreeableTrait;
use App\Component\DTO\Composition\UpdatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NarrativeDTO
 * @package App\Component\DTO
 * @ApiResource(
 *     shortName="fragment",
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "delete"}
 * )
 */
class FragmentDTO extends AbstractDTO
{
    use DatableTrait, UpdatableTrait, TreeableTrait;

    /**
     * @ApiProperty(identifier=true)
     */
    private $uuid;

    protected $children;

    /**
     * @var string
     */
    private $type;

    /**
     * @Assert\Length(
     *      max = 1024,
     *      maxMessage = "Your content cannot be longer than {{ limit }} characters"
     * )
     */
    private $content;

    /**
     * @var VersionDTO[]
     */
    private $versions;

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
     * @return VersionDTO[]
     */
    public function getVersions(): ?array
    {
        return $this->versions;
    }

    /**
     * @param VersionDTO[] $versions
     */
    public function setFragments(array $versions): void
    {
        $this->versions = $versions;
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}