<?php

namespace App\Repository;

use App\Component\Exception\EdoException;
use App\Entity\Fragment;
use App\Repository\Helper\RawSQLQueryHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


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
     * @param string $narrativeUuid
     * @return mixed[]
     * @throws EdoException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findNarrativeLastFragment(string $narrativeUuid)
    {
        $sql = '
            SELECT * FROM fragment f
            INNER JOIN qualification q ON q.fragment_id = f.id
            WHERE q.selected_uuid = :uuid
            ORDER BY f.created_at ASC
            LIMIT 1;
        ';

        try {
            $stmt = RawSQLQueryHelper::createCustomStatement($this->getEntityManager(), $sql, ['uuid' => $narrativeUuid]);
        }
        catch(EdoException $e)
        {
            throw new EdoException($e);
        }

        return $stmt->fetch();
    }

}
