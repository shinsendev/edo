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
        $sql = "SELECT f.* FROM fragment f
    INNER JOIN qualification q ON q.fragment_id = f.id
    INNER JOIN narrative n ON q.selected_uuid = n.uuid
    ORDER BY f.created_at, f.id DESC LIMIT ".$limit;

        // we map with a ResultSetMapping our result to a PHP Entity
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Narrative::class, 'fn');
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        // we get the result as usual
        return $query->getResult();
    }
}
