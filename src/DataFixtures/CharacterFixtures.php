<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Fiction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fiction = $manager->getRepository(Fiction::class)->findOneByUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');

        // todo : create 10 characters
        for ($i = 0;  $i <10; $i++) {
            $character = $this->generateCharacter();
            $character->setFiction($fiction);
            $manager->persist($character);
        }

        $manager->flush();
    }

    protected function generateCharacter(): Character
    {
        $character = new Character();
        $character->setFirstname('Name');
        $character->setLastname('Lastname');
        $character->setBirthYear(1900);
        $character->setDeathYear(2000);
        $character->setUuid(Uuid::uuid4());

        return $character;
    }

    public function getDependencies()
    {
        return array(
            FictionFixtures::class
        );
    }

}