<?php

namespace App\Repository;

use App\Entity\Fragment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method Fragment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fragment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fragment[]    findAll()
 * @method Fragment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FragmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fragment::class);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function findAllDistinctFragments(int $limit)
    {
        // just a little check to be sure, will need to be refacto and upgrade later
        if ($limit > 100) {
            $limit = 100;
        };

        // we get the last fragment for each code
        $sql = "SELECT DISTINCT ON (f.code) * FROM fragment f ORDER BY f.code, f.created_at DESC LIMIT ".$limit;

        // we map with a ResultSetMapping our result to a PHP Entity
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Fragment::class, 'f');
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        // we get the result as usual
        return $query->getResult();
    }

}
