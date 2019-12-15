<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class FragmentTest extends ApiTestCase
{
    public function testGetFragments()
    {
        $client = self::createClient();
        $client->request('GET', 'api/fragments');
        $this->assertResponseStatusCodeSame(200);
    }
}