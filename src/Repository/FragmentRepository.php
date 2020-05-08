<?php

namespace App\Repository;

use App\Component\DTO\Tree\PositionConvertor;
use App\Entity\Fiction;
use App\Entity\Fragment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
     * @param Fiction $fiction
     * @param int $limit
     * @return mixed
     */
    public function findLastNarratives(Fiction $fiction, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Fragment n WHERE n.fiction = :fiction ORDER BY n.updatedAt DESC
        ')->setParameter('fiction', $fiction)->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param Fragment $origin
     * @param int $limit
     * @return mixed
     */
    public function findAllNarrativeFragments(Fragment $origin, $limit = 100)
    {
        $rootPosition = PositionConvertor::getRootPosition($origin, $this->getEntityManager());

        $query = $this->getEntityManager()->createQuery(
            'SELECT f FROM App\Entity\Fragment f JOIN f.position p WHERE p.root = :narrativeOrigin ORDER BY p.lft ASC'
        )->setParameter('narrativeOrigin', $rootPosition->getId())->setMaxResults($limit);

        return $query->getResult();
    }

    public function findNarrativeByUuid(string $uuid)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT f FROM App\Entity\Fragment f JOIN f.position p WHERE p.lvl = 0 AND f.uuid = :uuid
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
