<?php

declare(strict_types=1);

namespace App\Tests\Integration;

class DefaultControllerTest extends EdoApiTestCase
{
    public function testGetDefault()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
