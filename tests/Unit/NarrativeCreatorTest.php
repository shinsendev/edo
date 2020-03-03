<?php


namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\NarrativeDTO;
use App\Component\Narratable\Narrative\NarrativeCreator;
use Liip\TestFixturesBundle\Test\FixturesTrait;

/**
 * Class NarrativeCreator
 * @package App\Tests\Unit
 */
class NarrativeCreatorTest extends AbstractUnitTest
{
    use FixturesTrait;

    public function setUp():void
    {
        parent::setUp();
        $this->loadFixtures([
            'App\DataFixtures\FictionFixtures',
            'App\DataFixtures\NarrativeFixtures',
            ]);
    }

    public function testNarrativeCreatorSave()
    {
        self::bootKernel();
        $container = self::$container;
        $creator = $container->get(NarrativeCreator::class);
        $response = $creator->save($this->generateNarrativeDTO());

        $this->assertEquals('Narrative content generated for test', $response->getContent());
        //todo : we can exclude seconds from the test to be sure everyhing is ok
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());

        //todo: implement the tree logic
    }

    /**
     * @return NarrativeDTO
     */
    protected function generateNarrativeDTO()
    {
        $dto = new NarrativeDTO();
        $dto->setUuid('6153ca18-47a9-4b38-ae72-29e8340060cb');
        $dto->setContent('Narrative content generated for test');
        // we use the fiction created with the fixtures
        $dto->setFictionUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');
        $dto->setParentUuid('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff');

        return $dto;
    }
}