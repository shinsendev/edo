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

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $fiction = $manager->getRepository(Fiction::class)->findOneByUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');

        // book 1
        $book = new Narrative();
        $book->setUuid('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff');
        $book->setFiction($fiction);
        $book->setCreatedAt(DateTimeHelper::now()->modify('-15 minutes'));
        $book->setUpdatedAt(DateTimeHelper::now()->modify('-15 minutes'));
        $manager->persist($book);

        // chap 1
        $chap1 = new Narrative();
        $chap1->setUuid('1b4705aa-4abd-4931-add0-ac11b6fff0c3');
        $chap1->setFiction($fiction);
        $chap1->setParent($book);
        $chap1->setCreatedAt(DateTimeHelper::now()->modify('-14 minutes'));
        $chap1->setUpdatedAt(DateTimeHelper::now()->modify('-14 minutes'));
        $manager->persist($chap1);

        // chap 1 part 1
        $chap1part1 = new Narrative();
        $chap1part1->setUuid('6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $chap1part1->setFiction($fiction);
        $chap1part1->setParent($chap1);
        $chap1part1->setCreatedAt(DateTimeHelper::now()->modify('-13 minutes'));
        $chap1part1->setUpdatedAt(DateTimeHelper::now()->modify('-13 minutes'));
        $manager->persist($chap1part1);

        // chap 1 part 2
        $chap1part2 = new Narrative();
        $chap1part2->setUuid('9aab1d64-a66b-47f9-8fe9-8464bdbab6da');
        $chap1part2->setParent($chap1part2);
        $chap1part2->setFiction($fiction);
        $chap1part2->setCreatedAt(DateTimeHelper::now()->modify('-12 minutes'));
        $chap1part2->setUpdatedAt(DateTimeHelper::now()->modify('-12 minutes'));
        $manager->persist($chap1part2);

        // chap 1 part 3
        $chap1part3 = new Narrative();
        $chap1part3->setUuid('d7d4899d-9b1c-44cd-8406-8c839c16f79f');
        $chap1part3->setParent($chap1part3);
        $chap1part3->setFiction($fiction);
        $chap1part3->setCreatedAt(DateTimeHelper::now()->modify('-11 minutes'));
        $chap1part3->setUpdatedAt(DateTimeHelper::now()->modify('-11 minutes'));
        $manager->persist($chap1part3);

        // chap 2
        $chap2 = new Narrative();
        $chap2->setUuid('a178e872-934c-4ff0-a7cf-34dccfdb9bb2');
        $chap2->setParent($book);
        $chap2->setFiction($fiction);
        $chap2->setCreatedAt(DateTimeHelper::now()->modify('-10 minutes'));
        $chap2->setUpdatedAt(DateTimeHelper::now()->modify('-10 minutes'));
        $manager->persist($chap2);

        // chap 2 part 1
        $chap2part1 = new Narrative();
        $chap2part1->setUuid('6aa31944-c4ec-4b03-a8e1-f44f54c56de6');
        $chap2part1->setParent($chap2);
        $chap2part1->setFiction($fiction);
        $chap2part1->setCreatedAt(DateTimeHelper::now()->modify('-9 minutes'));
        $chap2part1->setUpdatedAt(DateTimeHelper::now()->modify('-9 minutes'));
        $manager->persist($chap2part1);

        // chap 2 part 2
        $chap2part2 = new Narrative();
        $chap2part2->setUuid('5e110313-1f01-4f1e-8515-84c93fbb08ad');
        $chap2part2->setParent($chap2);
        $chap2part2->setFiction($fiction);
        $chap2part2->setCreatedAt(DateTimeHelper::now()->modify('-8 minutes'));
        $chap2part2->setUpdatedAt(DateTimeHelper::now()->modify('-8 minutes'));
        $manager->persist($chap2part2);

        $manager->flush();

        $this->addReference(self::NARRATIVE_REFERENCE_1, $book);
        $this->addReference(self::NARRATIVE_REFERENCE_2, $chap1);
    }

    public function getDependencies()
    {
        return array(
            FictionFixtures::class,
        );
    }
}