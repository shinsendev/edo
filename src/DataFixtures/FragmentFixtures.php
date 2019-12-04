<?php

namespace App\DataFixtures;

use App\Entity\Fragment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FragmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {

            $fragment = new Fragment();
            $fragment->setCode('fragment '.$i);
            $fragment->setTitle('title '.$i);
            $fragment->setContent('A simple fragment content.');
            $manager->persist($fragment);
        }

        $manager->flush();
    }
}
