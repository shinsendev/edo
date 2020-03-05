<?php

namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Faker\NarrativeDTOGenerator;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\Update\NarrativeDTOUpdate;
use App\Repository\NarrativeRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $em = $container->get(EntityManagerInterface::class);

        // narrative uuid must be the same for the DTO and the entity
        $narrativeUuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';
        $parentUuid = '1b4705aa-4abd-4931-add0-ac11b6fff0c3';
        $narrativeRepository = $container->get(NarrativeRepository::class);
        $narrativeDTO = NarrativeDTOGenerator::generate();
        $narrativeDTO->setUuid($narrativeUuid);
        $narrativeDTO->setParentUuid($parentUuid);

        $context = new DTOContext(
            new NarrativeDTOUpdate(),
            $narrativeDTO,
            $em,
            $narrativeRepository->findOneByUuid($narrativeUuid)
        );
        $response = $context->proceed();

        $this->assertEquals($narrativeUuid, $response->getUuid());
        $this->assertEquals($parentUuid, $response->getParentUuid());
        $this->assertEquals('Narrative content generated for test', $response->getContent());

        $datetime = DateTimeHelper::now()->modify('-13 minutes');
        $this->assertEquals(DateTimeHelper::stringify($datetime), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());
    }
}