<?php

namespace App\Repository;

use App\Entity\Narrative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Narrative|null find($id, $lockMode = null, $lockVersion = null)
 * @method Narrative|null findOneBy(array $criteria, array $orderBy = null)
 * @method Narrative[]    findAll()
 * @method Narrative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NarrativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Narrative::class);
    }

    public function findAllNarrativesLastFragments(int $limit)
    {
        // just a little check to be sure, will need to be refacto and upgrade later
        if ($limit > 100) {
            $limit = 100;
        };

        // we get the last fragment for each code
        $sql = "SELECT * FROM narrative n LIMIT ".$limit;

        // we map with a ResultSetMapping our result to a PHP Entity
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Narrative::class, 'fn');
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        // we get the result as usual
        return $query->getResult();
    }

    // /**
    //  * @return Narrative[] Returns an array of Narrative objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Narrative
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
