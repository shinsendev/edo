<?php

namespace App\Repository;

use App\Entity\Version;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Version|null find($id, $lockMode = null, $lockVersion = null)
 * @method Version|null findOneBy(array $criteria, array $orderBy = null)
 * @method Version[]    findAll()
 * @method Version[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Version::class);
    }

    /**
     * @param string $fragmentUuid
     * @param int $limit
     * @return mixed
     */
    public function findFragmentLastVersions(string $fragmentUuid, int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT v FROM '.Version::class.' v JOIN v.fragment f WHERE f.uuid = :uuid ORDER BY v.createdAt DESC
        ')
            ->setParameter('uuid', $fragmentUuid)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    /**
     * @param string $fragmentUuid
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countNarrativeFragments(string $fragmentUuid)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT COUNT(f) FROM '.Version::class.' f JOIN f.fragment n WHERE n.uuid = :uuid
        ')
            ->setParameter('uuid', $fragmentUuid);

        return $query->getSingleScalarResult();
    }

    // todo: keep for narration, when we'll need to connect characters, events, places, etc. with narratives, for the moment, everything is only connected to fiction
//    /**
//     * @param string $narrativeUuid
//     * @return mixed[]
//     * @throws EdoException
//     * @throws \Doctrine\DBAL\DBALException
//     */
//    public function findNarrativeLastFragment(string $narrativeUuid)
//    {
//        $sql = '
//            SELECT * FROM fragment f
//            INNER JOIN qualification q ON q.fragment_id = f.id
//            WHERE q.selected_uuid = :uuid
//            ORDER BY f.created_at ASC
//            LIMIT 1;
//        ';
//
//        try {
//            $stmt = RawSQLQueryHelper::createCustomStatement($this->getEntityManager(), $sql, ['uuid' => $narrativeUuid]);
//        }
//        catch(EdoException $e)
//        {
//            throw new EdoException($e);
//        }
//
//        return $stmt->fetch();
//    }

}
