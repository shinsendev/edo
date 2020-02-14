<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Fiction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FictionFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $fiction = new Fiction();
        $fiction->setUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');
        $fiction->setTitle('Fiction Title');
        $manager->persist($fiction);

        $fiction2 = new Fiction();
        $fiction2->setUuid('7e807cac-628f-425c-95b8-53eefd1236f3');
        $fiction2->setTitle('Fiction 2 Title');
        $manager->persist($fiction2);

        $manager->flush();
    }
}