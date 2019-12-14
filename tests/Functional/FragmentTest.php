<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\EdoWebTestCase;

class FragmentTest extends EdoWebTestCase
{
    public function testGetFragments()
    {
        $response = $this->client->request('GET', $_ENV['EDO_API_URL'].'/api/fragments');
        $content = json_decode($response->getContent());
        $arrayContent = (array) $content;

        $this->assertCount(2, $arrayContent['hydra:member']);
        $this->assertEquals('title Parent', $arrayContent['hydra:member'][0]->title);
        $this->assertEquals('A simple fragment content.', $arrayContent['hydra:member'][1]->content);
    }
}