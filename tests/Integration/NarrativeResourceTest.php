<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Liip\TestFixturesBundle\Test\FixturesTrait;


class NarrativeResourceTest extends EdoApiTestCase
{
    use FixturesTrait;

    /**
     * @Description = send GET request for one specific fragment
     */
    public function testGetNarrativeWithFragments()
    {
        $uuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';

        $response = $this->client->request('GET', 'api/narratives/'.$uuid);

        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();
        $this->assertEquals(2, count($arrayResponse['fragments']));
        $this->assertEquals($arrayResponse['fragments'][1]['title'], 'Fragment title');
        $this->assertEquals($arrayResponse['fragments'][0]['title'], 'Fragment title 2');
        $this->assertEquals($arrayResponse['uuid'], '6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $this->assertEquals($arrayResponse['content'], $arrayResponse['fragments'][0]['content']);
    }

    public function testGetNarrativesCollection()
    {
        // send GET request
        $response =  $this->client->request('GET', 'api/narratives', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();
        $this->assertCount(2, $arrayResponse['hydra:member']);
        $this->assertEquals('Fragment title 2', $arrayResponse['hydra:member'][0]['title']);
        $this->assertNotNull($arrayResponse['hydra:member'][1]['uuid']);
    }

    //    public function testPostFragment()
//    {
//        $container = static::$container;
//        $em = $container->get(EntityManagerInterface::class);
//
//        // before we created our fragment, we have 3 fragments in db
//        $this->assertEquals(3, count($em->getRepository(Fragment::class)->findAll()));
//
//        $data = '{"uuid":"57f107f2-a4cb-4b2d-862e-5c5fd8cf853e","code":"1","title":"First post test","content":"My first content with postman"}';
//
//        $response =  $this->client->request('POST', 'api/fragments', [
//            'json' => json_decode($data),
//            'headers' => ['Content-Type' => 'application/json']
//        ]);
//
//        $arrayResponse = $response->toArray();
//        $this->assertResponseIsSuccessful();
//        $this->assertEquals('My first content with postman', $arrayResponse['content']);
//
//        // we check that we have added another fragment
//        $this->assertEquals(4, count($em->getRepository(Fragment::class)->findAll()));
//    }
//
//    /**
//     * @throws \Exception
//     */
//    protected function createFragments()
//    {
//        $fragment = new Fragment();
//        $fragment->setTitle('Title');
//        $fragment->setContent('Some content');
//        $fragment->setCode('1234');
//        $uuid = Uuid::uuid4();
//        $fragment->setUuid($uuid);
//
//        $fragment2 = new Fragment();
//        $fragment2->setTitle('Another Title');
//        $fragment2->setContent('Some other content for text with 1234');
//        $fragment2->setCode('1234');
//        $now = new \DateTime();
//        // we add 30 seconds to the fragment creation date to be sur it is the last one
//        $fragment2->setCreatedAt($now->add(new \DateInterval('PT30S')));
//        $fragment2->setUpdatedAt($now->add(new \DateInterval('PT30S')));
//        // we fix an uuid for this fragment
//        $fragment->setUuid('35be83ef-a35a-4b8f-b59c-4aca2ce461b2');
//
//        $fragment3 = new Fragment();
//        $fragment3->setTitle('Title 2');
//        $fragment3->setContent('Some other content');
//        $fragment3->setCode('12345');
//        $fragment3->setParent($fragment2);
//        $uuid3 = Uuid::uuid4();
//        $fragment2->setUuid($uuid3);
//
//        self::bootKernel();
//        $container = static::$container;
//        $em = $container->get(EntityManagerInterface::class);
//        $em->persist($fragment);
//        $em->persist($fragment2);
//        $em->persist($fragment3);
//        $em->flush();
//    }

}