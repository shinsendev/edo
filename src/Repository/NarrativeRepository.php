<?php

namespace App\Repository;

use App\Component\Exception\EdoException;
use App\Entity\Fiction;
use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Repository\Helper\RawSQLQueryHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

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

    /**
     * @param int $limit
     * @return mixed
     */
    public function findLastNarratives(Fiction $fiction, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n WHERE n.fiction = :fiction ORDER BY n.updatedAt DESC
        ')->setParameter('fiction', $fiction)->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param Fiction $fiction
     * @param int $limit
     * @return mixed
     */
    public function findOrigins(Fiction $fiction, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n WHERE n.lvl = 0 AND n.fiction = :fiction ORDER BY n.updatedAt DESC
        ')->setParameter('fiction', $fiction)->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param Narrative $origin
     * @param int $limit
     * @return mixed
     */
    public function findOriginNarratives(Narrative $origin, $limit = 100)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT n FROM App\Entity\Narrative n WHERE n.root = :origin ORDER BY n.lft ASC'
        )->setParameter('origin', $origin)->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param Fiction $fiction
     * @param int $limit
     * @return mixed
     */
    public function findFollowings(Fiction $fiction, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n WHERE n.lvl != 0 AND n.fiction = :fiction ORDER BY n.updatedAt DESC
        ')->setParameter('fiction', $fiction)->setMaxResults($limit);

        return $query->getResult();
    }

    public function findOneOriginByNarrativeUuid(string $uuid)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n WHERE n.lvl = 0 AND n.uuid = :uuid
        ')->setParameter('uuid', $uuid);

        return $query->getSingleResult();
    }


//    /**
//     * @param string $narrativeId
//     * @return mixed[]
//     * @throws \Doctrine\DBAL\DBALException
//     */
//    public function findNarrativeWithFragments(string $narrativeId)
//    {
//        //we get by default the last 25 fragments
//        $sql = '
//                SELECT n.*, f.title, f.content, f.uuid as fragment_uuid, f.created_at as fragment_created_at FROM narrative n
//            INNER JOIN qualification q ON n.uuid = q.selected_uuid
//            INNER JOIN fragment f ON f.id = q.fragment_id
//            WHERE n.id = :id
//            ORDER BY f.created_at DESC
//            LIMIT 25
//        ';
//
//        $stmt = RawSQLQueryHelper::createCustomStatement($this->getEntityManager(), $sql, ['id' => $narrativeId]);
//
//        return $stmt->fetchAll();
//    }
//
//    /**
//     * @return mixed[]
//     * @throws EdoException
//     * @throws \Doctrine\DBAL\DBALException
//     */
//    public function findNarrativesCollectionWithLastFragments()
//    {
//        $sql = '
//            SELECT DISTINCT ON (n.id) n.*, f.title, f.content, f.uuid as fragment_uuid FROM narrative n
//    INNER JOIN qualification q ON n.uuid = q.selected_uuid
//    INNER JOIN fragment f ON f.id = q.fragment_id ORDER BY n.id, f.created_at DESC;
//        ';
//
//        try {
//            $stmt = RawSQLQueryHelper::createCustomStatement($this->getEntityManager(), $sql);
//        }
//        catch(EdoException $e) {
//            throw new EdoException($e);
//        }
//
//        return $stmt->fetchAll();
//    }
}
