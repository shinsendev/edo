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
    protected $selectedUuid;

    /**
     * @ORM\ManyToOne(targetEntity="Fragment", inversedBy="qualifications")
     * @ORM\Id()
     */
    protected $fragment;

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