<?php


namespace App\Component\Transformer;


use App\Component\DTO\DTOInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

class NarrativeDTOTransformer implements TransformerInterface
{
    /**
     * @param array $narratives
     * @return NarrativeDTO
     * @throws \Exception
     */
    public static function fromArray(array $narratives)
    {
        $narrativeDTO = NarrativeDTOTransformer::fromArrayWithoutFragments($narratives[0]);
        $narrativeDTO = NarrativeDTOTransformer::addFragments($narratives, $narrativeDTO);

        return $narrativeDTO;
    }

    /**
     * @param DTOInterface $dto
     * @param EntityManagerInterface $em
     * @return Narrative
     * @throws \Exception
     */
    public static function toEntity(DTOInterface $dto, EntityManagerInterface $em)
    {
        $narrative = new Narrative();
        $narrative->setUuid($dto->getUuid());

        // set datetimes
        $narrative->setCreatedAt(DateTimeHelper::now());
        $narrative->setUpdatedAt(DateTimeHelper::now());

        //todo : implement tree mapping, only the parent?

        // add fiction
        $narrative->setFiction($em->getRepository(Fiction::class)->findOneByUuid($dto->getFictionUuid()));

        return $narrative;
    }

    /**
     * @param Narrative $narrative
     * @param array $nested
     * @return NarrativeDTO
     *
     * @throws \App\Component\Exception\EdoException
     */
    public static function fromEntity(Narrative $narrative, array $nested = []): NarrativeDTO
    {
        $narrativeDTO = new NarrativeDTO();
        $narrativeDTO->setUuid($narrative->getUuid());

        // the last fragment set the title and content of the narrative
        $narrativeDTO->setTitle($narrative->getFragments()[0]->getTitle());
        $narrativeDTO->setContent($narrative->getFragments()[0]->getContent());
        $narrativeDTO->setCreatedAt(($narrative->getCreatedAt())->format('Y-m-d H:i:s'));
        $narrativeDTO->setUpdatedAt(($narrative->getUpdatedAt())->format('Y-m-d H:i:s'));

        // set tree info
        $narrativeDTO->setRoot($narrative->getRoot()->getUuid());
        if ($narrative->getParent()) {
            $narrativeDTO->setParent($narrative->getParent()->getUuid());
        }
        $narrativeDTO->setLft($narrative->getLft());
        $narrativeDTO->setLvl($narrative->getLvl());
        $narrativeDTO->setRgt($narrative->getRgt());

        // if it's not for the narratives collection, we add the last X fragments for the narrative
        $fragments = [];
        if (isset($nested['fragments'])) {
            foreach ($nested['fragments'] as $fragment) {
               $fragments[] = FragmentDTOTransformer::fromEntity($fragment);
            }
        }

        $narrativeDTO->setFragments($fragments);
        $narrativeDTO->setFictionUuid($narrative->getFiction()->getUuid());

        return $narrativeDTO;
    }

    /**
     * @param array $data
     * @return NarrativeDTO
     * @throws \Exception
     */
    public static function fromArrayWithoutFragments(array $data)
    {
        $narrativeDTO = new NarrativeDTO();

        // configure basic info
        $narrativeDTO->setTitle($data['title']);
        $narrativeDTO->setContent($data['content']);
        $narrativeDTO->setUuid($data['uuid']);

        // configure dates
        $narrativeDTO->setCreatedAt($data['created_at']);
        $narrativeDTO->setUpdatedAt($data['updated_at']);

        // configure tree structure
        $narrativeDTO->setRoot($data['tree_root']);
        $narrativeDTO->setParent($data['parent_id']);
        $narrativeDTO->setLft($data['lft']);
        $narrativeDTO->setLvl($data['lvl']);
        $narrativeDTO->setRgt($data['rgt']);

        return $narrativeDTO;
    }

    /**
     * @param array $narratives
     * @param NarrativeDTO $narrativeDTO
     * @return NarrativeDTO
     */
    public static function addFragments(array $narratives, NarrativeDTO $narrativeDTO)
    {
        $fragmentsDTO = [];

        // add embedded fragments DTO hydrated
        foreach ($narratives as $narrative) {
            $fragmentsDTO[] = FragmentDTOTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
        }

        $narrativeDTO->setFragments($fragmentsDTO);

        return $narrativeDTO;
    }

}