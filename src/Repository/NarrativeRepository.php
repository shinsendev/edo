<?php

namespace App\Repository;

use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Entity\Qualification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
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

    public function findNarrativeWithLastFragment(string $narrativeId)
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT n.*, f.title, f.content FROM narrative n
                INNER JOIN qualification q ON n.uuid = q.selected_uuid
                INNER JOIN fragment f ON f.id = q.fragment_id
                WHERE n.id = :id
                ORDER BY f.updated_at DESC
                LIMIT 1
        ';

        $stmt = $connection->prepare($sql);
        $stmt->execute(array('id' => $narrativeId));

        return $stmt->fetch();
    }

    public function findNarrativeWithFragments(string $narrativeId)
    {
        $connection = $this->getEntityManager()->getConnection();

        //we get by default the last 25 fragments
        $sql = '
                SELECT n.*, f.title, f.content, f.uuid as fragment_uuid FROM narrative n
            INNER JOIN qualification q ON n.uuid = q.selected_uuid
            INNER JOIN fragment f ON f.id = q.fragment_id
            WHERE n.id = :id
            ORDER BY f.updated_at DESC
            LIMIT 25
        ';

        $stmt = $connection->prepare($sql);
        $stmt->execute(array('id' => $narrativeId));

        return $stmt->fetchAll();

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
