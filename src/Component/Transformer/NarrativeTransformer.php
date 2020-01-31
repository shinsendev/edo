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

        $fragmentsDTO = [];

        // add embedded fragments DTO hydrated
        foreach ($narratives as $narrative) {
            $fragmentsDTO[] = FragmentTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
        }

        $narrativeDTO->setFragments($fragmentsDTO);

        return $narrativeDTO;
    }


}