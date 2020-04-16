<?php


namespace App\Component\EntityManager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SaveEntityTrait
 * @package App\Component\EntityManager
 */
class SaveEntityHelper
{
    /**
     * @param EntityManagerInterface $em
     * @param array $entities
     */
    public static function saveEntity(EntityManagerInterface $em, array $entities)
    {
        foreach ($entities as $entity) {
            $em->persist($entity);
        }

        $em->flush();
    }
}