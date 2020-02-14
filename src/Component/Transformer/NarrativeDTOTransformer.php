<?php


namespace App\Component\Transformer;


use App\Component\DTO\DTOInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\Exception\EdoException;
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
//        $narrativeDTO = NarrativeDTOTransformer::fromArrayWithoutFragments($narratives[0]);
//        $narrativeDTO = NarrativeDTOTransformer::addFragments($narratives, $narrativeDTO);
//
//        return $narrativeDTO;
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param EntityManagerInterface $em
     * @return Narrative
     * @throws \Exception
     */
    public static function toEntity(DTOInterface $narrativeDTO, EntityManagerInterface $em)
    {
        $narrative = new Narrative();

        try {
            $narrativeUuid = $narrativeDTO->getUuid();
        } catch(EdoException $e) {
            throw new EdoException('No uuid found for the narrative : ' . $e);
        }
        $narrative->setUuid($narrativeUuid);

        // set datetimes
        $narrative->setCreatedAt(DateTimeHelper::now());
        $narrative->setUpdatedAt(DateTimeHelper::now());

        //todo : implement tree mapping, only the parent?

        // add fiction
        try {
            $fictionUuid = $narrativeDTO->getFictionUuid();
        } catch(\Error $e) {
            throw new EdoException('No uuid found for the fiction : ' . $e);
        }

        $narrative->setFiction($em->getRepository(Fiction::class)->findOneByUuid($fictionUuid));

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
        // create DTO and add basics
        $narrativeDTO = new NarrativeDTO();
        $narrativeDTO->setUuid($narrative->getUuid());
        $narrativeDTO->setFictionUuid($narrative->getFiction()->getUuid());

        // add datetimes infos
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

        foreach ($nested['fragments'] as $fragment) {
           $fragments[] = FragmentDTOTransformer::fromEntity($fragment);
        }

        // if there are nested fragments we use them to set the title and content of the narrative
        $narrativeDTO->setTitle($nested['fragments'][0]->getTitle());
        $narrativeDTO->setContent($nested['fragments'][0]->getContent());

        $narrativeDTO->setFragments($fragments);

        return $narrativeDTO;
    }

//    /**
//     * @param array $data
//     * @return NarrativeDTO
//     * @throws \Exception
//     */
//    public static function fromArrayWithoutFragments(array $data)
//    {
//        $narrativeDTO = new NarrativeDTO();
//
//        // configure basic info
//        $narrativeDTO->setTitle($data['title']);
//        $narrativeDTO->setContent($data['content']);
//        $narrativeDTO->setUuid($data['uuid']);
//
//        // configure dates
//        $narrativeDTO->setCreatedAt($data['created_at']);
//        $narrativeDTO->setUpdatedAt($data['updated_at']);
//
//        // configure tree structure
//        $narrativeDTO->setRoot($data['tree_root']);
//        $narrativeDTO->setParent($data['parent_id']);
//        $narrativeDTO->setLft($data['lft']);
//        $narrativeDTO->setLvl($data['lvl']);
//        $narrativeDTO->setRgt($data['rgt']);
//
//        return $narrativeDTO;
//    }

//    /**
//     * @param array $narratives
//     * @param NarrativeDTO $narrativeDTO
//     * @return NarrativeDTO
//     */
//    public static function addFragments(array $narratives, NarrativeDTO $narrativeDTO)
//    {
//        $fragmentsDTO = [];
//
//        // add embedded fragments DTO hydrated
//        foreach ($narratives as $narrative) {
//            $fragmentsDTO[] = FragmentDTOTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
//        }
//
//        $narrativeDTO->setFragments($fragmentsDTO);
//
//        return $narrativeDTO;
//    }

}