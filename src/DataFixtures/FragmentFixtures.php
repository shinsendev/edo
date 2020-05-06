<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fiction;
use App\Entity\Fragment;
use App\Entity\Position;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FragmentFixtures extends Fixture implements DependentFixtureInterface
{
    public const FRAGMENT_REFERENCE_1 = 'fragment1';
    public const FRAGMENT_REFERENCE_2 = 'fragment2';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $fiction = $manager->getRepository(Fiction::class)->findOneByUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');

        // book 1
        $bookTime = DateTimeHelper::now()->modify('-15 minutes');
        $book = $this->manageFragment(
            $manager, 'de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff', $fiction, $bookTime, $bookTime
        );

        // chap 1
        $chap1Time = DateTimeHelper::now()->modify('-14 minutes');
        $chap1 = $this->manageFragment(
            $manager, '1b4705aa-4abd-4931-add0-ac11b6fff0c3', $fiction, $chap1Time, $chap1Time, $book['position']
        );

        // chap 1 part 1
        $chap1part1Time = DateTimeHelper::now()->modify('-13 minutes');
        $chap1part1 = $this->manageFragment(
            $manager, '6284e5ac-09cf-4334-9503-dedf31bafdd0', $fiction, $chap1part1Time, $chap1part1Time, $chap1['position']
        );

        // chap 1 part 2
        $chap1part2Time = DateTimeHelper::now()->modify('-12 minutes');
        $chap1part2 = $this->manageFragment(
            $manager, '9aab1d64-a66b-47f9-8fe9-8464bdbab6da', $fiction, $chap1part2Time, $chap1part2Time, $chap1['position']
        );

        // chap 1 part 3
        $chap1part3Time = DateTimeHelper::now()->modify('-11 minutes');
        $chap1part3 = $this->manageFragment(
            $manager, 'd7d4899d-9b1c-44cd-8406-8c839c16f79f', $fiction, $chap1part3Time, $chap1part3Time, $chap1['position']
        );

        // chap 2
        $chap2Time = DateTimeHelper::now()->modify('-10 minutes');
        $chap2 = $this->manageFragment(
            $manager, 'a178e872-934c-4ff0-a7cf-34dccfdb9bb2', $fiction, $chap2Time, $chap2Time, $book['position']
        );

        // chap 2 part 1
        $chap2part1Time = DateTimeHelper::now()->modify('-9 minutes');
        $chap2part1 = $this->manageFragment(
            $manager, '6aa31944-c4ec-4b03-a8e1-f44f54c56de6', $fiction, $chap2part1Time, $chap2part1Time, $chap2['position']
        );

        // chap 2 part 2
        $chap2part2Time = DateTimeHelper::now()->modify('-8 minutes');
        $chap2part2 = $this->manageFragment(
            $manager, '5e110313-1f01-4f1e-8515-84c93fbb08ad', $fiction, $chap2part2Time, $chap2part2Time, $chap2['position']
        );

        $manager->flush();

        $this->addReference(self::FRAGMENT_REFERENCE_1, $book['fragment']);
        $this->addReference(self::FRAGMENT_REFERENCE_2, $chap1['fragment']);
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
    public function generateFragmentWithPosition(
        String $uuid,
        Fiction $fiction,
        \DateTime $createdAd,
        \Datetime $updatedAt,
        Position $parent = null
    )
    {
        $fragment = new Fragment();
        $fragment->setUuid($uuid);
        $fragment->setFiction($fiction);
        $fragment->setCreatedAt($createdAd);
        $fragment->setUpdatedAt($updatedAt);

        $position = new Position();
        if($parent) {
            $position->setParent($parent);
        }

        $position->setFragment($fragment);

        return ['fragment' => $fragment, 'position' => $position];
    }

    /**
     * @param ObjectManager $manager
     * @param array $fragment
     */
    public function persistFragmentWithPosition(ObjectManager $manager, array $fragment)
    {
        $manager->persist($fragment['position']);
        $manager->persist($fragment['fragment']);
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
    public function manageFragment(
        ObjectManager $manager,
        String $uuid,
        Fiction $fiction,
        \DateTime $createdAd,
        \Datetime $updatedAt,
        Position $parent = null
    )
    {
        $fragment = $this->generateFragmentWithPosition($uuid, $fiction, $createdAd, $updatedAt, $parent);
        $this->persistFragmentWithPosition($manager, $fragment);

        return $fragment;
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