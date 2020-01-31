<?php


namespace App\Tests\Integration;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class EdoApiTestCase extends ApiTestCase
{
    use FixturesTrait;

    /** @var \ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client  */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->loadFixtures([
            'App\DataFixtures\FragmentFixtures',
            'App\DataFixtures\NarrativeFixtures'
        ]);
    }
}