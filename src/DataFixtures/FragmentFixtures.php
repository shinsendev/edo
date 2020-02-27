<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class FragmentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $narrative = $manager->getRepository(Narrative::class)->findOneByUuid('6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $narrative2 = $manager->getRepository(Narrative::class)->findOneByUuid('9aab1d64-a66b-47f9-8fe9-8464bdbab6da');
        $narrative3 = $manager->getRepository(Narrative::class)->findOneByUuid('');

        // narrative 1
        $fragment = self::generateFragment($narrative);
        $fragment->setUuid('553f3319-5093-421b-a8d2-42de34f31023');
        $fragment->setTitle('Chapitre 1 - Partie 1');
        $fragment->setContent(file_get_contents(__DIR__.'/Files/narrative1_fragment1.txt', true));
        $fragment->setCreatedAt(DateTimeHelper::now()->modify('-3 minutes'));
        $manager->persist($fragment);

        $fragment2 = self::generateFragment($narrative);
        $fragment2->setTitle('Chapitre 1 - Partie 1 - V2');
        $fragment2->setContent(file_get_contents(__DIR__.'/Files/narrative1_fragment2.txt', true));
        $fragment2->setCreatedAt(DateTimeHelper::now()->modify('-2 minutes'));
        $manager->persist($fragment2);

        $fragment3 = self::generateFragment($narrative2);
        $fragment3->setTitle('Chapter 1 - Part 2');
        $fragment3->setContent(file_get_contents(__DIR__.'/Files/narrative2.txt', true));
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $fragment3->setNarrative($narrative2);
        $manager->persist($fragment3);

        $fragment3 = self::generateFragment($narrative3);
        $fragment3->setTitle('Chapter 1 - Part 3');
        $fragment3->setContent(file_get_contents(__DIR__.'/Files/narrative3_fragment1.txt', true));
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $fragment3->setNarrative($narrative3);
        $manager->persist($fragment3);

        $fragment3 = self::generateFragment($narrative3);
        $fragment3->setTitle('Chapter 1 - Part 3 - V2');
        $fragment3->setContent(file_get_contents(__DIR__.'/Files/narrative3_fragment2.txt', true));
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $fragment3->setNarrative($narrative3);
        $manager->persist($fragment3);

        $fragment3 = self::generateFragment($narrative3);
        $fragment3->setTitle('Chapter 1 - Part 3 - V3');
        $fragment3->setContent(file_get_contents(__DIR__.'/Files/narrative3_fragment3.txt', true));
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $fragment3->setNarrative($narrative3);
        $manager->persist($fragment3);

        $manager->flush();
    }

    /**
     * @param Narrative $narrative
     * @return Fragment
     * @throws \Exception
     */
    public static function generateFragment(Narrative $narrative): Fragment
    {
        $fragment = new Fragment();

        // let the possibility to manually add uuid
        $fragment->setUuid(Uuid::uuid4());
        $fragment->setTitle('Title for '.$narrative->getUuid());
        $fragment->setContent('Content for '.$narrative->getUuid());
        $fragment->setCreatedAt(DateTimeHelper::now());
        $fragment->setNarrative($narrative);

        return $fragment;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            NarrativeFixtures::class,
        );
    }

}
