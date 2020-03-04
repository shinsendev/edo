<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy;

use App\Component\DTO\DTOInterface;
use App\Component\DTO\Strategy\Narrative\NarrativeDTOGetItem;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DTOContext
 * @package App\Component\DTO\Context
 */
class DTOContext
{
    /** @var DTOStrategyInterface  */
    private $strategy;

    /** @var DTOStrategyConfig  */
    private $config;

    /**
     * DTOContext constructor.
     * @param DTOStrategyInterface $strategy
     * @param DTOInterface|null $dto
     * @param EntityManagerInterface|null $em
     * @param EntityInterface|null $entity
     */
    public function __construct(
        DTOStrategyInterface $strategy,
        DTOInterface $dto = null,
        EntityManagerInterface $em = null,
        EntityInterface $entity = null
    )
    {
        $this->strategy = $strategy;
        $this->config = new DTOStrategyConfig($dto, $em, $entity);
    }

    /**
     * @return mixed
     */
    public function proceed() {
        return $this->strategy->proceed($this->config);
    }
}