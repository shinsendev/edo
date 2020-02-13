<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Component\Date\DateTimeHelper;
use App\Component\Generator\FragmentGenerator;
use App\Entity\Narrative;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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

        $fragment = FragmentGenerator::generateFragment($narrative);
        $fragment->setUuid('553f3319-5093-421b-a8d2-42de34f31023');
        $fragment->setTitle('Fragment title');
        $fragment->setContent('A simple fragment content.');
        $fragment->setCreatedAt(DateTimeHelper::now()->modify('-3 minutes'));
        $manager->persist($fragment);

        $fragment2 = FragmentGenerator::generateFragment($narrative);
        $fragment2->setTitle('Fragment title 2');
        $fragment2->setContent('A new fragment content.');
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment2->setCreatedAt(DateTimeHelper::now()->modify('-2 minutes'));
        $manager->persist($fragment2);

        $fragment3 = FragmentGenerator::generateFragment($narrative);
        $fragment3->setTitle('title Parent 3');
        $fragment3->setContent('A third fragment content.');
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));
        $fragment3->setNarrative($narrative2);
        $manager->persist($fragment3);

        $manager->flush();
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
