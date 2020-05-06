<?php

declare(strict_types=1);


namespace App\Tests\Integration\Fragment;


class OriginResourceGetTest extends AbstractFragmentResource
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
        $this->assertEquals(1, count($arrayResponse['hydra:member']));
        $this->assertEquals(2, count($arrayResponse['hydra:member'][0]['children']), 'Origin must have two children');
        $this->assertNull($arrayResponse['hydra:member'][0]['parent_uuid']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['lft']);
        $this->assertEquals(0, $arrayResponse['hydra:member'][0]['lvl']);
        $this->assertEquals($arrayResponse['hydra:member'][0]['children'][0]['content'], 'Chapitre 1', 'First children content is not correct');
        $this->assertEquals(count($arrayResponse['hydra:member'][0]['children'][0]['children']), 3, 'Chapitre 1 has 3 children');
        $this->assertEquals(count($arrayResponse['hydra:member'][0]['children'][1]['children']), 2, 'Chapitre 2 has 2 children');
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['lft']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['root']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['rgt']);
        $this->assertEquals(1, $arrayResponse['hydra:member'][0]['children'][1]['lvl']);
        $this->assertEquals(2, $arrayResponse['hydra:member'][0]['children'][1]['children'][0]['lvl']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['children'][0]['lft']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['children'][0]['root']);
        $this->assertNotNull($arrayResponse['hydra:member'][0]['children'][1]['children'][0]['parent_uuid']);

        $this->assertEquals('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff', $arrayResponse['hydra:member'][0]['uuid']);

    }
}