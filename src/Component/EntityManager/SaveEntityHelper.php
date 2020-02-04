<?php


namespace App\Component\EntityManager;

/**
 * Class SaveEntityTrait
 * @package App\Component\EntityManager
 */
class SaveEntityHelper
{
    /**
     * @param $em
     * @param $entity
     */
    public static function saveEntity($em, $entity)
    {
        $em->persist($entity);
        $em->flush();
    }
}