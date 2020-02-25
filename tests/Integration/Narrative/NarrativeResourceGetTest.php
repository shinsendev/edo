<?php

declare(strict_types=1);

namespace App\Tests\Integration\Narrative;

/**
 * Class NarrativeResourceTest
 * @package App\Tests\Integration
 */
class NarrativeResourceGetTest extends AbstractNarrativeResource
{
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
        $this->assertEquals($arrayResponse['content'], $arrayResponse['fragments'][0]['content'], 'Not the correct content');
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
        $this->assertEquals('title Parent 3', $arrayResponse['hydra:member'][0]['title']);
        $this->assertNotNull($arrayResponse['hydra:member'][1]['uuid']);
    }

    public function testGetNarrativeWithIncorrectUuid()
    {
        $uuid = 'cakeIsALie';
        $this->client->request('GET', 'api/narratives/'.$uuid);
        $this->assertResponseStatusCodeSame(500);
    }

    public function testGetNarrativeWithUnkwnonUuid()
    {
        $uuid = '9f6e6490-85f3-4d4e-82fd-e725a884fd8e';
        $this->client->request('GET', 'api/narratives/'.$uuid);
        $this->assertResponseStatusCodeSame(404);
    }

}