<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fragment;
use App\Entity\Version;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class VersionFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $bookFragment = $manager->getRepository(Fragment::class)->findOneByUuid('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff');

        $chap1Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('1b4705aa-4abd-4931-add0-ac11b6fff0c3');
        $chap1Part1Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $chap1Part2Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('9aab1d64-a66b-47f9-8fe9-8464bdbab6da');
        $chap1Part3Fragment =  $manager->getRepository(Fragment::class)->findOneByUuid('d7d4899d-9b1c-44cd-8406-8c839c16f79f');

        $chap2Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('a178e872-934c-4ff0-a7cf-34dccfdb9bb2');
        $chap2Part1Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('6aa31944-c4ec-4b03-a8e1-f44f54c56de6');
        $chap2Part2Fragment = $manager->getRepository(Fragment::class)->findOneByUuid('5e110313-1f01-4f1e-8515-84c93fbb08ad');

        // book 1 de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff
        $book = self::generateFragment($bookFragment);
        $book->setUuid('fd8facee-ca94-4db0-8ff1-e82e817e2029');
        $book->setContent('Livre 1');
        $book->setCreatedAt(DateTimeHelper::now()->modify('-15 minutes'));
        $manager->persist($book);

        // chapter 1 1b4705aa-4abd-4931-add0-ac11b6fff0c3
        $chap1 = self::generateFragment($chap1Fragment);
        $chap1->setUuid('0cddb6e2-d3c5-4b00-b5c3-b6870298195e');
        $chap1->setContent('Chapitre 1');
        $chap1->setCreatedAt(DateTimeHelper::now()->modify('-15 minutes'));
        $manager->persist($chap1);

        // chapter 1 part 1 6284e5ac-09cf-4334-9503-dedf31bafdd0
        $chap1part1 = self::generateFragment($chap1Part1Fragment);
        $chap1part1->setUuid('e7cc4025-030c-44a5-8c6f-b756575176b6');
        $chap1part1->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part1_v1.txt', true));
        $chap1part1->setCreatedAt(DateTimeHelper::now()->modify('-14 minutes'));
        $manager->persist($chap1part1);

        $chap1part1V2 = self::generateFragment($chap1Part1Fragment);
        $chap1part1V2->setUuid('03c340fa-b881-4c73-b634-63264382d8f5');
        $chap1part1V2->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part1_v2.txt', true));
        $chap1part1V2->setCreatedAt(DateTimeHelper::now()->modify('-13 minutes'));
        $manager->persist($chap1part1V2);

        // chapter 1 part 2 9aab1d64-a66b-47f9-8fe9-8464bdbab6da
        $chap1part2 = self::generateFragment($chap1Part2Fragment);
        $chap1part2->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part2_v1.txt', true));
        $chap1part2->setCreatedAt(DateTimeHelper::now()->modify('-12 minutes'));
        $manager->persist($chap1part2);

        // chapter 1 part 3 d7d4899d-9b1c-44cd-8406-8c839c16f79f
        $chap1part3 = self::generateFragment($chap1Part3Fragment);
        $chap1part3->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part3_v1.txt', true));
        $chap1part3->setCreatedAt(DateTimeHelper::now()->modify('-11 minutes'));
        $manager->persist($chap1part3);

        // chapter 1 part 3 V2
        $chap1part3V2 = self::generateFragment($chap1Part3Fragment);
        $chap1part3V2->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part3_v2.txt', true));
        $chap1part3V2->setCreatedAt(DateTimeHelper::now()->modify('-9 minutes'));
        $manager->persist($chap1part3V2);

        // chapter 1 part 3 V3
        $chap1part3V3 = self::generateFragment($chap1Part3Fragment);
        $chap1part3V3->setContent(file_get_contents(__DIR__.'/Files/book1_chap1_part3_v3.txt', true));
        $chap1part3V3->setCreatedAt(DateTimeHelper::now()->modify('-8 minutes'));
        $manager->persist($chap1part3V3);

        // chap 2 a178e872-934c-4ff0-a7cf-34dccfdb9bb2
        $chap2 = self::generateFragment($chap2Fragment);
        $chap2->setContent('Chapitre 2');
        $chap2->setCreatedAt(DateTimeHelper::now()->modify('-7 minutes'));
        $manager->persist($chap2);

        // chap 2 part 1 6aa31944-c4ec-4b03-a8e1-f44f54c56de6
        $chap2part1 = self::generateFragment($chap2Part1Fragment);
        $chap2part1->setContent(file_get_contents(__DIR__.'/Files/book1_chap2_part1_v1.txt', true));
        $chap2part1->setCreatedAt(DateTimeHelper::now()->modify('-6 minutes'));
        $manager->persist($chap2part1);

        // chap 2 part 1 V2
        $chap2part1V2 = self::generateFragment($chap2Part1Fragment);
        $chap2part1V2->setContent(file_get_contents(__DIR__.'/Files/book1_chap2_part1_v2.txt', true));
        $chap2part1V2->setCreatedAt(DateTimeHelper::now()->modify('-5 minutes'));
        $manager->persist($chap2part1);

        // chap 3 part 2 5e110313-1f01-4f1e-8515-84c93fbb08ad
        $chap2part2 = self::generateFragment($chap2Part2Fragment);
        $chap2part2->setContent(file_get_contents(__DIR__.'/Files/book1_chap2_part2_v1.txt', true));
        $chap2part2->setCreatedAt(DateTimeHelper::now()->modify('-9 minutes'));
        $manager->persist($chap2part2);

        $manager->flush();
    }

    /**
     * @param Fragment $fragment
     * @return Version
     * @throws \Exception
     */
    public static function generateFragment(Fragment $fragment): Version
    {
        $version = new Version();

        // let the possibility to manually add uuid
        $version->setUuid(Uuid::uuid4());
        $version->setContent('Content for '.$fragment->getUuid());
        $version->setCreatedAt(DateTimeHelper::now());
        $version->setFragment($fragment);

        return $version;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            FragmentFixtures::class,
        );
    }

}
