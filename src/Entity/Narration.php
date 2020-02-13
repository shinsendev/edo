<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * narration is a relation between a narrative and a narratable
 *
 * Class Narration
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\NarrationRepository")
 * @ORM\Table(name="narration",
 *     uniqueConstraints={
 *       @ORM\UniqueConstraint(name="narration_unique", columns={"narratable_uuid", "narrative_id"})
 *     })
 */
class Narration
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Narrative")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Id()
     */
    private $narrative;

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id()
     */
    private $narratableUuid;

    /**
     * @ORM\Column(type="integer",
     *  options={"comment": "Selected Type, for instance : narrative 1, character 2, etc."})
     */
    private $narratableType;

    public function getNarrative(): ?Narrative
    {
        return $this->narrative;
    }

    public function setNarrative(?Narrative $narrative): self
    {
        $this->narrative = $narrative;

        return $this;
    }

    public function getNarratableUuid(): ?string
    {
        return $this->narratableUuid;
    }

    public function setNarratableUuid(string $narratableUuid): self
    {
        $this->narratableUuid = $narratableUuid;

        return $this;
    }

    public function getNarratableType(): ?int
    {
        return $this->narratableType;
    }

    public function setNarratableType(int $narratableType): self
    {
        $this->narratableType = $narratableType;

        return $this;
    }

}
