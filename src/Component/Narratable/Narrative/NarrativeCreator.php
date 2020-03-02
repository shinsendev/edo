<?php


namespace App\Component\Narratable\Narrative;

use App\Component\DTO\NarrativeDTO;
use App\Component\EntityManager\EntityManagerTrait;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Fiction;
use App\Repository\FictionRepository;

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
     *
     * @return NarrativeDTO
     *
     * @throws \Exception
     */
    public function save(NarrativeDTO $narrativeDTO)
    {
        $narrative = NarrativeDTOTransformer::toEntity($narrativeDTO, $this->em);
        SaveEntityHelper::saveEntity($this->em, $narrative);
        FragmentSaver::save($this->em, $narrativeDTO);

        return NarrativeResponseCreator::createResponse($narrativeDTO, $narrative);
    }
}