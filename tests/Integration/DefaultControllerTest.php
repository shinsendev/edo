<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class DefaultControllerTest extends ApiTestCase
{
    public function testGetDefault()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
