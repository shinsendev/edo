<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class EdoWebTestCase extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = HttpClient::create();
    }
}