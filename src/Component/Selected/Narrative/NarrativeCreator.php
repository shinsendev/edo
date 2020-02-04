<?php


namespace App\Component\Selected\Narrative;

use App\Component\DTO\NarrativeDTO;
use App\Component\EntityManager\EntityManagerTrait;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Transformer\NarrativeDTOTransformer;

/**
 * Class NarrativeCreator
 * @package App\Component\Selected\Narrative
 */
class NarrativeCreator
{
    use EntityManagerTrait;

    /**
     * @Description : create a new narrative with its fragment and relation
     *
     * @param NarrativeDTO $narrativeDTO
     * @return NarrativeDTO
     */
    public function save(NarrativeDTO $narrativeDTO)
    {
        $narrative = NarrativeDTOTransformer::toEntity($narrativeDTO);
        SaveEntityHelper::saveEntity($this->em, $narrative);
        FragmentSaver::save($this->em, $narrativeDTO, $narrative->getUuid());

        return NarrativeResponseCreator::createResponse($narrativeDTO, $narrative);
    }
}