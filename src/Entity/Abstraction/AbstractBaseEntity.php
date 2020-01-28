<?php


namespace App\Entity\Abstraction;

use Doctrine\ORM\Mapping as ORM;

class AbstractBaseEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}