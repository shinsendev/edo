<?php

namespace App\Repository;

use App\Component\Exception\EdoException;
use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Repository\Helper\RawSQLQueryHelper;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Narrative|null find($id, $lockMode = null, $lockVersion = null)
 * @method Narrative|null findOneBy(array $criteria, array $orderBy = null)
 * @method Narrative[]    findAll()
 * @method Narrative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NarrativeRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(Narrative::class));
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function findLastNarratives(int $limit = 10)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n 
        ')
        ->setMaxResults($limit);

        return $query->getResult();
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
