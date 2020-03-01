<?php

namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Faker\NarrativeDTOGenerator;
use App\Component\Narratable\Narrative\NarrativeUpdater;
use App\Repository\NarrativeRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;

/**
 * Class NarrativeUpdaterTest
 * @package App\Tests\Unit
 */
class NarrativeUpdaterTest extends AbstractUnitTest
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

    public function testNarrativeUpdaterUpdate()
    {
        self::bootKernel();
        $container = self::$container;
        $generator = $container->get(NarrativeUpdater::class);
        // narrative uuid must be the same for the DTO and the entity
        $narrativeUuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';
        $narrativeRepository = $container->get(NarrativeRepository::class);
        $narrativeDTO = NarrativeDTOGenerator::generate();
        $narrativeDTO->setUuid($narrativeUuid);

        $response = $generator->update($narrativeDTO, $narrativeRepository->findOneByUuid($narrativeUuid));

        $this->assertEquals($narrativeUuid, $response->getUuid());
        $this->assertEquals('Narrative content generated for test', $response->getContent());

        $datetime = DateTimeHelper::now()->modify('-13 minutes');
        $this->assertEquals(DateTimeHelper::stringify($datetime), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());
    }
}