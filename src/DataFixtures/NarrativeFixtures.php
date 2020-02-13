<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Selected\SelectedType;
use App\Entity\Fiction;
use App\Entity\Narrative;
use App\Entity\Qualification;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NarrativeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fiction = $manager->getRepository(Fiction::class)->findOneByUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');

        $narrative = new Narrative();
        $narrative->setUuid('6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $narrative->setFiction($fiction);
        $manager->persist($narrative);

        $fragment = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_1);
        $fragment2 = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_2);
        $fragment3 = $this->getReference(FragmentFixtures::FRAGMENT_REFERENCE_3);

        $qualification = new Qualification();
        $qualification->setFragment($fragment);
        $qualification->setSelectedUuid($narrative->getUuid());
        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
        $manager->persist($qualification);

        $qualification = new Qualification();
        $qualification->setFragment($fragment2);
        $qualification->setSelectedUuid($narrative->getUuid());
        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
        $manager->persist($qualification);

        $child = new Narrative();
        $child->setParent($narrative);
        $child->setFiction($fiction);

        $qualification = new Qualification();
        $qualification->setFragment($fragment3);
        $qualification->setSelectedUuid($child->getUuid());
        $qualification->setSelectedType(SelectedType::NARRATIVE_TYPE);
        $manager->persist($qualification);

        $manager->persist($child);
        $manager->flush();
    }
}