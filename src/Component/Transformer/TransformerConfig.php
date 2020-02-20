<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use Doctrine\ORM\EntityManagerInterface;

class TransformerConfig
{
    /** @var TransformableInterface */
    private $source;

    /** @var EntityManagerInterface */
    private $em;

    /** @var array */
    private $options;

    /**
     * @description: could be nested entity or nested DTO
     * @var TransformableInterface[]
     */
    private $nested;

    public function __construct(
        TransformableInterface $source,
        array $nested = [],
        EntityManagerInterface $em = null,
        array $options = []
    )
    {
        $this->source = $source;
        $this->nested = $nested;
        $this->em = $em;
        $this->options = $options;
    }

    /**
     * @return TransformableInterface
     */
    public function getSource(): TransformableInterface
    {
        return $this->source;
    }

    /**
     * @param TransformableInterface $source
     */
    public function setSource(TransformableInterface $source): void
    {
        $this->source = $source;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getNested(): array
    {
        return $this->nested;
    }

    /**
     * @param array $nested
     */
    public function setNested(array $nested): void
    {
        $this->nested = $nested;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}