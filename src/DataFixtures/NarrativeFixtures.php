<?php

declare(strict_types=1);

namespace App\DataFixtures;

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
        $manager->persist($narrative);

//        $fragment = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_1);
//        $fragment2 = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_2);
//        $fragment3 = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_3);
//
//        $qualification = new Qualification();
//        $qualification->setFragment($fragment);
//        $qualification->setSelectedUuid($narrative->getUuid());
//        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
//        $manager->persist($qualification);
//
//        $qualification = new Qualification();
//        $qualification->setFragment($fragment2);
//        $qualification->setSelectedUuid($narrative->getUuid());
//        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
//        $manager->persist($qualification);

        $child = new Narrative();
        $child->setUuid('9aab1d64-a66b-47f9-8fe9-8464bdbab6da');
        $child->setParent($narrative);
        $child->setFiction($fiction);
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