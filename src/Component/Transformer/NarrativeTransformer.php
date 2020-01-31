<?php


namespace App\Component\Transformer;


use App\Component\DTO\NarrativeDTO;

class NarrativeTransformer
{
    /**
     * @param array $narrative
     * @return NarrativeDTO
     * @throws \Exception
     */
    public static function createNarrativeDTOFromSQLSingleResponse(array $narrative)
    {
        $narrativeDTO = new NarrativeDTO();
        $narrativeDTO->setTitle($narrative['title']);
        $narrativeDTO->setContent($narrative['content']);
        $now = new \DateTime();
        $now = date_format($now, 'Y-m-d H:i:s');
        $narrativeDTO->setCreatedAt($now);
        $narrativeDTO->setUpdatedAt($now);
        $narrativeDTO->setUuid($narrative['uuid']);
        $narrativeDTO->setFragments([]);

        return $narrativeDTO;
    }

    /**
     * @param array $narratives
     * @return NarrativeDTO
     */
    public function createNarrativeDTOFromSQLFetchAll(array $narratives)
    {
//        dd($narratives);
        $narrativeDTO = new NarrativeDTO();

        $narrativeDTO->setUuid($narratives[0]['uuid']);
        $narrativeDTO->setTitle($narratives[0]['title']);
        $narrativeDTO->setContent($narratives[0]['content']);
        $narrativeDTO->setCreatedAt($narratives[0]['created_at']);
        $narrativeDTO->setUpdatedAt($narratives[0]['updated_at']);

        // add embedded fragments DTO hydrated
        foreach ($narratives as $narrative) {
            $fragmentsDTO[] = FragmentTransformer::createEmbeddedFragmentFromSingleSQL($narrative);
        }

        $narrativeDTO->setFragments($fragmentsDTO);

        return $narrativeDTO;
    }


}