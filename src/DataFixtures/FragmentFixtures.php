<?php

namespace App\DataFixtures;

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

        $manager->persist($fragment);

        $fragment2 = new Fragment();
        $fragment2->setTitle('Fragment title 2');
        $fragment2->setContent('A new fragment content.');
        $now = new \DateTime();
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment2->setCreatedAt($now->add(new \DateInterval('PT30S')));
        $fragment2->setUpdatedAt($now->add(new \DateInterval('PT30S')));

        $manager->persist($fragment2);

        $fragment3 = new Fragment();
        $fragment3->setTitle('title Parent 3');
        $fragment3->setContent('A third fragment content.');
        $now = new \DateTime();
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment2->setCreatedAt($now->add(new \DateInterval('PT35S')));
        $fragment2->setUpdatedAt($now->add(new \DateInterval('PT35S')));

        $manager->persist($fragment3);

        $manager->flush();

        // add reference for other fixtures
        $this->addReference(self::FRAGMENT_REFERENCE_1, $fragment);
        $this->addReference(self::FRAGMENT_REFERENCE_2, $fragment2);
        $this->addReference(self::FRAGMENT_REFERENCE_3, $fragment3);
    }
}
