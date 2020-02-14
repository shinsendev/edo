<?php

namespace App\Repository;

use App\Entity\Narration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Narration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Narration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Narration[]    findAll()
 * @method Narration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NarrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Narration::class);
    }

}
