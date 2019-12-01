<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testGetDefault()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $response = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertEquals('0.1.0', json_decode($response));
    }
}
