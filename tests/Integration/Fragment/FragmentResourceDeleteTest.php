<?php

declare(strict_types=1);

namespace App\Tests\Integration\Fragment;

/**
 * Class NarrativeResourceTest
 * @package App\Tests\Integration
 */
class FragmentResourceDeleteTest extends AbstractFragmentResource
{
    /**
     * @Description = send GET request for one specific fragment
     */
    public function testDeleteNarrative()
    {
        $uuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';
        $this->client->request('DELETE', 'api/fragments/'.$uuid);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);
    }
}