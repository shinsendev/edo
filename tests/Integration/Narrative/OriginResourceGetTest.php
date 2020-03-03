<?php

declare(strict_types=1);


namespace App\Tests\Integration\Narrative;


class OriginResourceGetTest extends AbstractNarrativeResource
{
    /**
     * @Description = send GET request for one specific fragment
     */
    public function testGetOrigin()
    {
        $uuid = 'de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff';

        $response = $this->client->request('GET', 'api/origins/'.$uuid);

        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();
        $this->assertEquals(8, count($arrayResponse['hydra:member']));
        $this->assertEquals('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff', $arrayResponse['hydra:member'][0]['uuid']);
        $this->assertEquals('5e110313-1f01-4f1e-8515-84c93fbb08ad', $arrayResponse['hydra:member'][7]['uuid']);
    }
}