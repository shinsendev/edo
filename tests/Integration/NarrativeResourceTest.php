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
        $this->assertEquals($arrayResponse['fragments'][1]['title'], 'Fragment title 2');
        $this->assertEquals($arrayResponse['fragments'][0]['title'], 'Fragment title');
        $this->assertEquals($arrayResponse['uuid'], '6284e5ac-09cf-4334-9503-dedf31bafdd0');
        $this->assertEquals($arrayResponse['content'], $arrayResponse['fragments'][0]['content']);
    }


}