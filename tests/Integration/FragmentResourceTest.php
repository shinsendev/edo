<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class FragmentResourceTest extends ApiTestCase
{
    public function testGetFragments()
    {
        $this->createFragments();

        $client = self::createClient();
        $client->request('GET', 'api/fragments');
        $this->assertResponseStatusCodeSame(200);
    }

    protected function createFragments()
    {
        $fragment = new Fragment();
        $fragment->setTitle('Title');
        $fragment->setContent('Some content');
        $fragment->setCode('1234');
        $uuid = Uuid::uuid4();
        $fragment->setUuid($uuid);

        $fragment2 = new Fragment();
        $fragment2->setTitle('Title 2');
        $fragment2->setContent('Some other content');
        $fragment2->setCode('12345');
        $fragment2->setParent($fragment);
        $uuid2 = Uuid::uuid4();
        $fragment2->setUuid($uuid2);

        self::bootKernel();
        $container = static::$container;
        $em = $container->get(EntityManagerInterface::class);
        $em->persist($fragment);
        $em->persist($fragment2);
        $em->flush();
    }
}