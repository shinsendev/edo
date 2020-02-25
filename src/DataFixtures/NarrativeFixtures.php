<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NarrativeFixtures extends Fixture
{
    public const NARRATIVE_REFERENCE_1 = 'narrative1';
    public const NARRATIVE_REFERENCE_2 = 'narrative2';

    public function load(ObjectManager $manager)
    {
        $fiction = $manager->getRepository(Fiction::class)->findOneByUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');

        $narrative = new Narrative();
        $narrative->setUuid('6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $narrative->setFiction($fiction);
        $narrative->setCreatedAt(DateTimeHelper::now()->modify('-2 minutes'));
        $narrative->setUpdatedAt(DateTimeHelper::now()->modify('-2 minutes'));
        $manager->persist($narrative);

        $child = new Narrative();
        $child->setUuid('9aab1d64-a66b-47f9-8fe9-8464bdbab6da');
        $child->setParent($narrative);
        $child->setFiction($fiction);
        $narrative->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $narrative->setUpdatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $manager->persist($child);

        $manager->flush();

        $this->addReference(self::NARRATIVE_REFERENCE_1, $narrative);
        $this->addReference(self::NARRATIVE_REFERENCE_2, $child);
    }

    public function getDependencies()
    {
        return array(
            FictionFixtures::class,
        );
    }
}