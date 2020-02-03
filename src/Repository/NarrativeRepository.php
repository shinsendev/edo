<?php

namespace App\Repository;

use App\Entity\Narrative;
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

    public function findNarrativeWithFragments(string $narrativeId)
    {
        //we get by default the last 25 fragments
        $sql = '
                SELECT n.*, f.title, f.content, f.uuid as fragment_uuid FROM narrative n
            INNER JOIN qualification q ON n.uuid = q.selected_uuid
            INNER JOIN fragment f ON f.id = q.fragment_id
            WHERE n.id = :id
            ORDER BY f.updated_at DESC
            LIMIT 25
        ';

        $stmt = $this->createCustomStatement($sql, ['id' => $narrativeId]);

        return $stmt->fetchAll();
    }

    public function findNarrativesCollectionWithLastFragments()
    {
        $sql = '
            SELECT DISTINCT ON (n.id) n.*, f.title, f.content, f.uuid as fragment_uuid FROM narrative n
    INNER JOIN qualification q ON n.uuid = q.selected_uuid
    INNER JOIN fragment f ON f.id = q.fragment_id ORDER BY n.id, f.updated_at DESC;
        ';

        $stmt = $this->createCustomStatement($sql);

        return $stmt->fetchAll();
    }

    /**
     * @param string $sql
     * @param array $options
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    private function createCustomStatement(string $sql, array $options = [])
    {
        $connection = $this->getEntityManager()->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($options);

        return $stmt;
    }
}
