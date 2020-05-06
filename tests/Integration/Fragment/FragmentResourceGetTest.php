<?php

declare(strict_types=1);

namespace App\Tests\Integration\Fragment;

/**
 * Class NarrativeResourceTest
 * @package App\Tests\Integration
 */
class FragmentResourceGetTest extends AbstractFragmentResource
{
    /**
     * @Description = send GET request for one specific fragment
     */
    public function testGetNarrativeWithFragments()
    {
        $uuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';

        $response = $this->client->request('GET', 'api/fragments/'.$uuid);

        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();

        $this->assertEquals(2, count($arrayResponse['versions']));
        $this->assertEquals($arrayResponse['versions'][1]['uuid'], 'e7cc4025-030c-44a5-8c6f-b756575176b6');
        $this->assertEquals($arrayResponse['versions'][0]['uuid'], '03c340fa-b881-4c73-b634-63264382d8f5');
        $this->assertEquals($arrayResponse['uuid'], '6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $this->assertEquals($arrayResponse['content'], $arrayResponse['versions'][0]['content'], 'Not the correct content');
    }

    public function testGetNarrativesCollection()
    {
        // send GET request
        $response =  $this->client->request('GET', 'api/fragments', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();
        $this->assertCount(8, $arrayResponse['hydra:member']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['uuid']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['content']);
        $this->assertNotNull($arrayResponse['hydra:member'][1]['uuid']);
        $this->assertNotNull($arrayResponse['hydra:member'][1]['content']);
    }

    public function testGetNarrativeWithIncorrectUuid()
    {
        $uuid = 'cakeIsALie';
        $this->client->request('GET', 'api/fragments/'.$uuid);
        $this->assertResponseStatusCodeSame(500);
    }

    public function testGetNarrativeWithUnkwnonUuid()
    {
        $uuid = '9f6e6490-85f3-4d4e-82fd-e725a884fd8e';
        $this->client->request('GET', 'api/fragments/'.$uuid);
        $this->assertResponseStatusCodeSame(404);
    }

}