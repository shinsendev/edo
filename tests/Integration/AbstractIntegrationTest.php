<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Tests\AbstractEdoApiTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

abstract class AbstractIntegrationTest extends AbstractEdoApiTestCase
{
    use FixturesTrait;

    /** @var \ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client  */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->loadFixtures([
            'App\DataFixtures\FictionFixtures',
            'App\DataFixtures\NarrativeFixtures',
            'App\DataFixtures\FragmentFixtures'
        ]);
    }
}

