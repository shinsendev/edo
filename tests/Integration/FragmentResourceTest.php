<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Ramsey\Uuid\Uuid;

class FragmentResourceTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testGetFragments()
    {
        // create client first
        $client = static::createClient();

        // add some data
        $this->createFragments();

        // send GET request
        $response =  $client->request('GET', 'api/fragments', [
            'headers' => ['Content-Type' => 'application/json']
        ]);


        // test the fragments, 3 fragments are created but only two should be displayed (one for each code)
        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();
        $this->assertCount(2, $arrayResponse['hydra:member']);
        $this->assertEquals('Another Title', $arrayResponse['hydra:member'][0]['title']);
        $this->assertEquals('12345', $arrayResponse['hydra:member'][1]['code']);
    }

    /**
     * @throws \Exception
     */
    protected function createFragments()
    {
        $fragment = new Fragment();
        $fragment->setTitle('Title');
        $fragment->setContent('Some content');
        $fragment->setCode('1234');
        $uuid = Uuid::uuid4();
        $fragment->setUuid($uuid);

        $fragment2 = new Fragment();
        $fragment2->setTitle('Another Title');
        $fragment2->setContent('Some other content for text with 1234');
        $fragment2->setCode('1234');
        $now = new \DateTime();
        // we add 30 seconds to the fragment creation date to be sur it is the last one
        $fragment2->setCreatedAt($now->add(new \DateInterval('PT30S')));
        $fragment2->setUpdatedAt($now->add(new \DateInterval('PT30S')));
        $uuid2 = Uuid::uuid4();
        $fragment2->setUuid($uuid2);

        $fragment3 = new Fragment();
        $fragment3->setTitle('Title 2');
        $fragment3->setContent('Some other content');
        $fragment3->setCode('12345');
        $fragment3->setParent($fragment2);
        $uuid3 = Uuid::uuid4();
        $fragment2->setUuid($uuid3);

        self::bootKernel();
        $container = static::$container;
        $em = $container->get(EntityManagerInterface::class);
        $em->persist($fragment);
        $em->persist($fragment2);
        $em->persist($fragment3);
        $em->flush();
    }
}