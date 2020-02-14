<?php

namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Faker\NarrativeDTOGenerator;
use App\Component\Narratable\Narrative\NarrativeUpdater;
use App\Repository\NarrativeRepository;
use App\Tests\AbstractEdoApiTestCase;

/**
 * Class NarrativeUpdaterTest
 * @package App\Tests\Unit
 */
class NarrativeUpdaterTest extends AbstractEdoApiTestCase
{
    public function testNarrativeUpdaterUpdate()
    {
        $container = self::$container;
        $generator = $container->get(NarrativeUpdater::class);
        // narrative uuid must be the same for the DTO and the entity
        $narrativeUuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';
        $narrativeRepository = $container->get(NarrativeRepository::class);
        $narrativeDTO = NarrativeDTOGenerator::generate();
        $narrativeDTO->setUuid($narrativeUuid);

        $response = $generator->update($narrativeDTO, $narrativeRepository->findOneByUuid($narrativeUuid));

        $this->assertEquals('Narrative title generated', $response->getTitle());
        $this->assertEquals($narrativeUuid, $response->getUuid());
        $this->assertEquals('Narrative content generated for test', $response->getContent());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());
    }
}