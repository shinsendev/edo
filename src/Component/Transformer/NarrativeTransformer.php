<?php


namespace App\Component\Transformer;


use App\Component\DTO\NarrativeDTO;

class NarrativeTransformer
{
    /**
     * @param array $narratives
     * @return NarrativeDTO
     */
    public static function createNarrativeDTOFromSQLFetchAll(array $narratives)
    {
        $narrativeDTO = new NarrativeDTO();

        $narrativeDTO->setUuid($narratives[0]['uuid']);
        $narrativeDTO->setTitle($narratives[0]['title']);
        $narrativeDTO->setContent($narratives[0]['content']);
        $narrativeDTO->setCreatedAt($narratives[0]['created_at']);
        $narrativeDTO->setUpdatedAt($narratives[0]['updated_at']);
        $narrativeDTO->setUuid($narratives[0]['uuid']);
        $narrativeDTO->setRoot($narratives[0]['tree_root']);
        $narrativeDTO->setParent($narratives[0]['parent_id']);
        $narrativeDTO->setLft($narratives[0]['lft']);
        $narrativeDTO->setLvl($narratives[0]['lvl']);
        $narrativeDTO->setRgt($narratives[0]['rgt']);
        $fragmentsDTO = [];

        // add embedded fragments DTO hydrated
        foreach ($narratives as $narrative) {
            $fragmentsDTO[] = FragmentTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
        }

        $narrativeDTO->setFragments($fragmentsDTO);

        return $narrativeDTO;
    }

    /**
     * @param array $narrative
     * @return NarrativeDTO
     * @throws \Exception
     */
    public static function createNarrativeDTOFromSQLSingleResult(array $narrative)
    {
        $narrativeDTO = new NarrativeDTO();
        $narrativeDTO->setTitle($narrative['title']);
        $narrativeDTO->setContent($narrative['content']);
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        $narrativeDTO->setCreatedAt($now);
        $narrativeDTO->setUpdatedAt($now);
        $narrativeDTO->setUuid($narrative['uuid']);
        $narrativeDTO->setRoot($narrative['tree_root']);
        $narrativeDTO->setParent($narrative['parent_id']);
        $narrativeDTO->setLft($narrative['lft']);
        $narrativeDTO->setLvl($narrative['lvl']);
        $narrativeDTO->setRgt($narrative['rgt']);

        return $narrativeDTO;
    }


}