<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct($manager, $manager->getClassMetadata(Position::class));
    }

    public function findNarrative(int $positionId)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT n FROM App\Entity\Narrative n JOIN n.position p WHERE p.id = :position
        ')->setParameter('position', $positionId)->setMaxResults(1);

        return $query->getSingleResult();
    }
}
