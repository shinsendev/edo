<?php

declare(strict_types=1);

namespace App\Tests\Integration\Fiction;

use App\Tests\Integration\AbstractIntegrationTest;

class FictionResourceGetTest extends AbstractIntegrationTest
{
    public function testGetFiction() {
        $fictionUuid = '1b7df281-ae2a-40bf-ad6a-ac60409a9ce6';

        $response = $this->client->request('GET', 'api/fictions/'.$fictionUuid);
        $this->assertResponseIsSuccessful();
        $arrayResponse = $response->toArray();

        $this->assertEquals($arrayResponse['title'], 'Fiction Title', 'Wrong fiction title');
        $this->assertEquals($arrayResponse['content'], '', 'Wrong fiction content');
        $this->assertEquals(2, count($arrayResponse['narratives']), 'Wrong narratives number.');
        $this->assertEquals(1, count($arrayResponse['origins']), 'Wrong origins number.');
        $this->assertEquals(1, count($arrayResponse['followings']), 'Wrong followings number');
        $this->assertEquals(10, count($arrayResponse['characters']), 'Wrong characters number');
    }
}