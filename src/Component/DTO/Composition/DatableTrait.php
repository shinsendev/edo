<?php


namespace App\Component\DTO\Composition;

/**
 * Trait DatableTrait
 * @package App\Component\DTO\Composition
 */
trait DatableTrait
{
    /**
     * @var string
     */
    private $createdAt;

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

}