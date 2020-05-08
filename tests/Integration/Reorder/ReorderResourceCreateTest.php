<?php

declare(strict_types=1);

namespace App\Tests\Integration\Fragment;

use App\Entity\Position;

/**
 * Class FragmentResourceCreateTest
 * @package App\Tests\Integration\Narrative
 */
class ReorderResourceCreateTest extends AbstractFragmentResource
{
    public function testCreateReorder()
    {
        // check position for a narrative before reorder
        $fragmentUuid = "1b4705aa-4abd-4931-add0-ac11b6fff0c3";
        $fragment = $this->fragmentRepository->findOneByUuid($fragmentUuid);

        $positionRepository = $this->em->getRepository(Position::class);
        $position = $positionRepository->findOneByFragment($fragment);
        $parentPosition = $positionRepository->findOneById($position->getParent()->getId());

        $this->assertEquals(2, $position->getLft());
        $this->assertEquals(1, $position->getLvl());
        $this->assertEquals(9, $position->getRgt());
        $this->assertEquals($parentPosition, $position->getParent());

        $reorderData = [
          "fragmentUuid" => $fragmentUuid,
          "position"=> 2,
          "parentUuid" => "de88bad6-9e5d-4af4-ba0c-bbe4dbbf82ff"
        ];

        $this->client->request('POST', 'api/reorders', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => $reorderData
        ]);

        $this->assertResponseIsSuccessful();

        $updatedPosition = $positionRepository->findOneByFragment($fragment);
        $updatedParentPosition = $positionRepository->findOneById($position->getParent()->getId());

        $this->assertEquals(4, $updatedPosition->getLft());
        $this->assertEquals(1, $updatedPosition->getLvl());
        $this->assertEquals(5, $updatedPosition->getRgt());

        $this->assertEquals($updatedParentPosition, $updatedPosition->getParent());
    }

}