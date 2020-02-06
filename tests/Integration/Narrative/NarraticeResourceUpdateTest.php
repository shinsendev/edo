<?php


namespace App\Tests\Integration\Narrative;


use App\Repository\FragmentRepository;
use App\Repository\NarrativeRepository;
use App\Tests\AbstractEdoApiTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class NarraticeResourceUpdateTest extends AbstractNarrativeResourceTest
{
    /**
     * @Description: we create a new fragment for an existing narrative, it's like updating this narrative
     */
    public function testUpdateNarrative()
    {
        // at first, we count the number of existing narratives
        $this->assertEquals(2, count($this->narrativeRepository->findAll()), 'Uncorrect number of narratives');

        // and we count fragments
        $this->assertEquals(3, count($this->fragmentRepository->findAll()), 'Uncorrect number of fragments');

        // send request to create a new fragment for an existing narrative
        $this->data['uuid'] = '6284e5ac-09cf-4334-9503-dedf31bafdd0';

        // create a new fragment for an existing narrative
        $this->client->request('POST', 'api/narratives', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $this->data
        ]);

        $this->assertResponseIsSuccessful();

        // there are no more narratives but one more fragments
        $this->assertEquals(2, count($this->narrativeRepository->findAll()), 'Uncorrect number of narratives');
        $this->assertEquals(4, count($this->fragmentRepository->findAll()), 'Uncorrect number of fragments');

        // get the updated narrative
        $response = $this->client->request('GET', 'api/narratives/'.$this->data['uuid']);
        $arrayResponse = $response->toArray();

        // check if there is one more fragment
        $this->assertEquals(3, count($arrayResponse['fragments']));

        // check the fragment data
        $this->assertEquals($arrayResponse['fragments'][0]['title'], $this->title);
        $this->assertNotEquals($arrayResponse['fragments'][0]['title'], $arrayResponse['fragments'][2]['title']);
        $this->assertEquals($arrayResponse['fragments'][0]['content'], $this->content);

        // check if narrative infos has been correctly updated
        $this->assertEquals($arrayResponse['title'], $this->title);
        $this->assertEquals($arrayResponse['content'], $this->content);
        $this->assertEquals($arrayResponse['uuid'], '6284e5ac-09cf-4334-9503-dedf31bafdd0');
    }
}