<?php


namespace App\Tests\Unit;

use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOContext;
use App\Component\DTO\Strategy\Narrative\Save\FragmentDTOSave;
use App\Component\DTO\Strategy\Narrative\Save\NarrativeDTOSave;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;

/**
 * Class NarrativeCreator
 * @package App\Tests\Unit
 */
class FragmentDTOSaveTest extends AbstractUnitTest
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

    public function testFragmentCreatorSave()
    {
        self::bootKernel();
        $container = self::$container;

        $em = $container->get(EntityManagerInterface::class);
        $context = new DTOContext(new FragmentDTOSave(), $this->generateFragmentDTO(), $em);
        $response = $context->proceed();

        $this->assertEquals('Narrative content generated for test', $response->getContent());
        //todo : we can exclude seconds from the test to be sure everyhing is ok
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getCreatedAt());
        $this->assertEquals(DateTimeHelper::humanNow(), $response->getUpdatedAt());

        //todo: implement the tree logic
    }

    /**
     * @return FragmentDTO
     */
    protected function generateFragmentDTO()
    {
        $dto = new FragmentDTO();
        $dto->setUuid('6153ca18-47a9-4b38-ae72-29e8340060cb');
        $dto->setContent('Narrative content generated for test');
        // we use the fiction created with the fixtures
        $dto->setFictionUuid('1b7df281-ae2a-40bf-ad6a-ac60409a9ce6');
        $dto->setParentUuid('de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff');

        return $dto;
    }
}