<?php


namespace App\Tests\Unit;


use App\Component\DateTime\DateTimeHelper;
use App\Component\Selected\Narrative\NarrativeUpdater;
use App\Tests\Helper\NarrativeTestGenerator;
use App\Tests\Integration\EdoApiTestCase;

/**
 * Class NarrativeUpdaterTest
 * @package App\Tests\Unit
 */
class NarrativeUpdaterTest extends EdoApiTestCase
{
    public function testNarrativeUpdaterUpdate()
    {
        $container = self::$container;
        $generator = $container->get(NarrativeUpdater::class);
        $response = $generator->update(NarrativeTestGenerator::generateDTO(), NarrativeTestGenerator::generateEntity());

        $this->assertEquals('Narrative title generated', $response->getTitle());
        $this->assertEquals('6153ca18-47a9-4b38-ae72-29e8340060cb', $response->getUuid());
        $this->assertEquals('Narrative content generated for test', $response->getContent());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());
    }
}