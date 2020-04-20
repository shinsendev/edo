<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy;

use App\Component\DTO\Model\DTOInterface;
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
     * @param array $data
     */
    public function __construct(
        DTOStrategyInterface $strategy,
        DTOInterface $dto = null,
        EntityManagerInterface $em = null,
        array $data = []
    )
    {
        $this->strategy = $strategy;
        $this->config = new DTOStrategyConfig($dto, $em, $data);
    }

    /**
     * @return mixed
     */
    public function proceed() {
        return $this->strategy->proceed($this->config);
    }
}