<?php

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Fiction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param Fiction $fiction
     * @param int $limit
     * @return mixed
     */
    public function findLastCharacters(Fiction $fiction, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT c FROM App\Entity\Character c WHERE c.fiction = :fiction ORDER BY c.updatedAt DESC
        ')->setParameter('fiction', $fiction)->setMaxResults($limit);

        return $query->getResult();
    }

}
