<?php

namespace App\Repository;

use App\Entity\Fiction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fiction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiction[]    findAll()
 * @method Fiction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiction::class);
    }
}
