<?php


namespace App\Component\DTO\Composition;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait DatableTrait
 * @package App\Component\DTO\Composition
 */
trait UpdatableTrait
{
    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}