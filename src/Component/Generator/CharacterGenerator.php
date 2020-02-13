<?php

declare(strict_types=1);

namespace App\Component\Generator;

use App\Entity\Character;
use Ramsey\Uuid\Uuid;

class CharacterGenerator implements GeneratorInterface
{
    public static function generate(): Character
    {
        $character = new Character();
        $character->setFirstname('Name');
        $character->setLastname('Lastname');
        $character->setUuid(Uuid::uuid4());

        return $character;
    }
}