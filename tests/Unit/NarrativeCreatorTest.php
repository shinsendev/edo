<?php


namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\Generator\NarrativeGenerator;
use App\Component\Selected\Narrative\NarrativeCreator;
use App\Tests\AbstractEdoApiTestCase;

/**
 * Class NarrativeCreator
 * @package App\Tests\Unit
 */
class NarrativeCreatorTest extends AbstractEdoApiTestCase
{
    public function testNarrativeCreatorSave()
    {
        $container = self::$container;
        $creator = $container->get(NarrativeCreator::class);
        $response = $creator->save(NarrativeGenerator::generateDTO());

        $this->assertEquals('Narrative title generated', $response->getTitle());
        $this->assertEquals('Narrative content generated for test', $response->getContent());
        //todo : we can exclude seconds from the test to be sure everyhing is ok
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());

        //todo: implement the tree logic
    }
}