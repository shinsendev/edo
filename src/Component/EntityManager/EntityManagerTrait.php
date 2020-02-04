<?php

declare(strict_types=1);

namespace App\Component\EntityManager;


use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerTrait
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * NarrativeUpdater constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}