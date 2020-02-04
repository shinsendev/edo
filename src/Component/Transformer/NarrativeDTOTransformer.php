<?php


namespace App\Component\Transformer;


use App\Component\DTO\NarrativeDTO;

class NarrativeDTOTransformer
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

    public static function addFragments(array $narratives, NarrativeDTO $narrativeDTO)
    {
        $fragmentsDTO = [];

        // add embedded fragments DTO hydrated
        foreach ($narratives as $narrative) {
            $fragmentsDTO[] = FragmentTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
        }

        $narrativeDTO->setFragments($fragmentsDTO);

        return $narrativeDTO;
    }

}