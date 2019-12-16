<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class DefaultControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testGetDefault()
    {
        $client = self::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
