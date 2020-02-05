<?php

namespace App\DataFixtures;

use App\Component\DateTime\DateTimeHelper;
use App\Entity\Fragment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FragmentFixtures extends Fixture
{
    public const FRAGMENT_REFERENCE_1 = 'fragment1';
    public const FRAGMENT_REFERENCE_2 = 'fragment2';
    public const FRAGMENT_REFERENCE_3 = 'fragment3';

    public function load(ObjectManager $manager)
    {
        $fragment = new Fragment();
        $fragment->setTitle('Fragment title');
        $fragment->setContent('A simple fragment content.');
        $fragment->setUuid('553f3319-5093-421b-a8d2-42de34f31023');
        $fragment->setCreatedAt(DateTimeHelper::now()->modify('-3 minutes'));

        $manager->persist($fragment);

        $fragment2 = new Fragment();
        $fragment2->setTitle('Fragment title 2');
        $fragment2->setContent('A new fragment content.');
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment2->setCreatedAt(DateTimeHelper::now()->modify('-2 minutes'));

        $manager->persist($fragment2);

        $fragment3 = new Fragment();
        $fragment3->setTitle('title Parent 3');
        $fragment3->setContent('A third fragment content.');
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment3->setCreatedAt(DateTimeHelper::now()->modify('-1 minute'));

        $manager->persist($fragment3);

        $manager->flush();

        // add reference for other fixtures
        $this->addReference(self::FRAGMENT_REFERENCE_1, $fragment);
        $this->addReference(self::FRAGMENT_REFERENCE_2, $fragment2);
        $this->addReference(self::FRAGMENT_REFERENCE_3, $fragment3);
    }
}
