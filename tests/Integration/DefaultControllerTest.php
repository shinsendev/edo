<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Tests\AbstractEdoApiTestCase;

class DefaultControllerTest extends AbstractEdoApiTestCase
{
    public function testGetDefault()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
