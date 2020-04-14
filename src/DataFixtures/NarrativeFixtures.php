<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fiction;
use App\Entity\Narrative;
use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class NarrativeFixtures extends Fixture implements DependentFixtureInterface
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
        $bookTime = DateTimeHelper::now()->modify('-15 minutes');
        $book = $this->manageNarrative(
            $manager, 'de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff', $fiction, $bookTime, $bookTime
        );

        // chap 1
        $chap1Time = DateTimeHelper::now()->modify('-14 minutes');
        $chap1 = $this->manageNarrative(
            $manager, '1b4705aa-4abd-4931-add0-ac11b6fff0c3', $fiction, $chap1Time, $chap1Time, $book['position']
        );

        // chap 1 part 1
        $chap1part1Time = DateTimeHelper::now()->modify('-13 minutes');
        $chap1part1 = $this->manageNarrative(
            $manager, '6284e5ac-09cf-4334-9503-dedf31bafdd0', $fiction, $chap1part1Time, $chap1part1Time, $chap1['position']
        );

        // chap 1 part 2
        $chap1part2Time = DateTimeHelper::now()->modify('-12 minutes');
        $chap1part2 = $this->manageNarrative(
            $manager, '9aab1d64-a66b-47f9-8fe9-8464bdbab6da', $fiction, $chap1part2Time, $chap1part2Time, $chap1['position']
        );

        // chap 1 part 3
        $chap1part3Time = DateTimeHelper::now()->modify('-11 minutes');
        $chap1part3 = $this->manageNarrative(
            $manager, 'd7d4899d-9b1c-44cd-8406-8c839c16f79f', $fiction, $chap1part3Time, $chap1part3Time, $chap1['position']
        );

        // chap 2
        $chap2Time = DateTimeHelper::now()->modify('-10 minutes');
        $chap2 = $this->manageNarrative(
            $manager, 'a178e872-934c-4ff0-a7cf-34dccfdb9bb2', $fiction, $chap2Time, $chap2Time, $book['position']
        );

        // chap 2 part 1
        $chap2part1Time = DateTimeHelper::now()->modify('-9 minutes');
        $chap2part1 = $this->manageNarrative(
            $manager, '6aa31944-c4ec-4b03-a8e1-f44f54c56de6', $fiction, $chap2part1Time, $chap2part1Time, $chap2['position']
        );

        // chap 2 part 2
        $chap2part2Time = DateTimeHelper::now()->modify('-8 minutes');
        $chap2part2 = $this->manageNarrative(
            $manager, '5e110313-1f01-4f1e-8515-84c93fbb08ad', $fiction, $chap2part2Time, $chap2part2Time, $chap2['position']
        );

        $manager->flush();

        $this->addReference(self::NARRATIVE_REFERENCE_1, $book['narrative']);
        $this->addReference(self::NARRATIVE_REFERENCE_2, $chap1['narrative']);
    }

    /**
     * @param String $uuid
     * @param Fiction $fiction
     * @param \DateTime $createdAd
     * @param \Datetime $updatedAt
     * @param Position|null $parent
     * @return array
     * @throws \Exception
     */
    public function generateNarrativeWithPosition(
        String $uuid,
        Fiction $fiction,
        \DateTime $createdAd,
        \Datetime $updatedAt,
        Position $parent = null
    )
    {
        $narrative = new Narrative();
        $narrative->setUuid($uuid);
        $narrative->setFiction($fiction);
        $narrative->setCreatedAt($createdAd);
        $narrative->setUpdatedAt($updatedAt);

        $position = new Position();
        if($parent) {
            $position->setParent($parent);
        }

        $narrative->setPosition($position);

        return ['narrative' => $narrative, 'position' => $position];
    }

    /**
     * @param ObjectManager $manager
     * @param array $narrative
     */
    public function persistNarrativeWithPosition(ObjectManager $manager, array $narrative)
    {
        $manager->persist($narrative['position']);
        $manager->persist($narrative['narrative']);
    }

    /**
     * @param ObjectManager $manager
     * @param String $uuid
     * @param Fiction $fiction
     * @param \DateTime $createdAd
     * @param \Datetime $updatedAt
     * @param Position|null $parent
     * @return array
     * @throws \Exception
     */
    public function manageNarrative(
        ObjectManager $manager,
        String $uuid,
        Fiction $fiction,
        \DateTime $createdAd,
        \Datetime $updatedAt,
        Position $parent = null
    )
    {
        $narrative = $this->generateNarrativeWithPosition($uuid, $fiction, $createdAd, $updatedAt, $parent);
        $this->persistNarrativeWithPosition($manager, $narrative);

        return $narrative;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            FictionFixtures::class,
        );
    }
}