<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\EdoWebTestCase;

class DefaultControllerTest extends EdoWebTestCase
{
    public function testGetDefault()
    {
        $response = $this->client->request('GET', $_ENV['EDO_API_URL']);
        $content = json_decode($response->getContent());
        $this->assertEquals('0.1.0', $content);
    }
}
