<?php

namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Faker\FragmentDTOGenerator;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\Update\FragmentDTOUpdate;
use App\Component\DTO\Strategy\Narrative\Update\NarrativeDTOUpdate;
use App\Repository\FragmentRepository;
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
            'App\DataFixtures\FragmentFixtures',
        ]);
    }

    public function testFragmentUpdaterUpdate()
    {
        self::bootKernel();
        $container = self::$container;
        $em = $container->get(EntityManagerInterface::class);

        // narrative uuid must be the same for the DTO and the entity
        $fragmentUuid = '6284e5ac-09cf-4334-9503-dedf31bafdd0';
        $parentUuid = '1b4705aa-4abd-4931-add0-ac11b6fff0c3';
        $fragmentRepository = $container->get(FragmentRepository::class);
        $fragmentDTO = FragmentDTOGenerator::generate();
        $fragmentDTO->setUuid($fragmentUuid);
        $fragmentDTO->setParentUuid($parentUuid);

        $context = new DTOContext(
            new FragmentDTOUpdate(),
            $fragmentDTO,
            $em,
            ['fragment' => $fragmentRepository->findOneByUuid($fragmentUuid)]
        );
        $response = $context->proceed();

        $this->assertEquals($fragmentUuid, $response->getUuid());
        $this->assertEquals($parentUuid, $response->getParentUuid());
        $this->assertEquals('Narrative content generated for test', $response->getContent());

        $datetime = DateTimeHelper::now()->modify('-13 minutes');
        $this->assertEquals(DateTimeHelper::stringify($datetime), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());
    }
}