<?php

declare(strict_types=1);


namespace App\Tests\Integration\Fiction;


class FictionResourceGetTest
{
    public function testGetFiction() {
        $fictionUuid = '1b7df281-ae2a-40bf-ad6a-ac60409a9ce6';

        $response = $this->client->request();
    }

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
}