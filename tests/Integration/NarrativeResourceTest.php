<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;


class NarrativeResourceTest extends EdoApiTestCase
{
    use FixturesTrait;

    public function testGetNarrativeWithFragments()
    {

        // send GET request for one specific fragment
        $uuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';

        $response = $this->client->request('GET', 'api/narratives/'.$uuid);

        $this->assertResponseIsSuccessful();
//        $arrayResponse = $response->toArray();
//        $this->assertEquals('Some content', $arrayResponse['content']);
//        $this->assertEquals('1234', $arrayResponse['code']);
    }


}