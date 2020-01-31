<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * qualification is a relation between a fragment and a selection
 *
 * Class Qualification
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="qualification",
 *     uniqueConstraints={
        @ORM\UniqueConstraint(name="qualification_unique", columns={"selected_uuid", "fragment_id"})
 *     })
 */
class Qualification
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id()
     */
    private $selectedUuid;

    /**
     * @ORM\Column(
     *     type="string",
     *     options={"comment": "Selected Type, for instance : narrative, character, etc."}
     * )
     */
    private $selectedType;

    /**
     * @ORM\ManyToOne(targetEntity="Fragment", inversedBy="qualifications")
     * @ORM\Id()
     */
    private $fragment;


    /**
     * @return mixed
     */
    public function getSelectedUuid()
    {
        return $this->selectedUuid;
    }

    /**
     * @param mixed $selectedUuid
     */
    public function setSelectedUuid($selectedUuid): void
    {
        $this->selectedUuid = $selectedUuid;
    }

    /**
     * @return mixed
     */
    public function getSelectedType()
    {
        return $this->selectedType;
    }

    /**
     * @param mixed $selectedType
     */
    public function setSelectedType($selectedType): void
    {
        $this->selectedType = $selectedType;
    }

    /**
     * @return mixed
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param mixed $fragment
     */
    public function setFragment($fragment): void
    {
        $this->fragment = $fragment;
    }

}