<?php


namespace App\Tests\Unit;

use App\Component\DateTime\DateTimeHelper;
use App\Component\Selected\Narrative\NarrativeCreator;
use App\Tests\Helper\NarrativeTestGenerator;
use App\Tests\Integration\EdoApiTestCase;

/**
 * Class NarrativeCreator
 * @package App\Tests\Unit
 */
class NarrativeCreatorTest extends EdoApiTestCase
{
    public function testNarrativeCreatorSave()
    {
        $container = self::$container;
        $creator = $container->get(NarrativeCreator::class);
        $response = $creator->save(NarrativeTestGenerator::generateDTO());

        $this->assertEquals('Narrative title generated', $response->getTitle());
        $this->assertEquals('Narrative content generated for test', $response->getContent());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());

        //todo: implement the tree logic
    }
}