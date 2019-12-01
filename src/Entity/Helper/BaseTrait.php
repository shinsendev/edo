<?php

namespace App\Entity\Helper;


trait BaseTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    protected $createdAt;

    protected $updatedAt;

    /**
     * @ORM\Column(type="string")
     */
    protected $uuid;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}
