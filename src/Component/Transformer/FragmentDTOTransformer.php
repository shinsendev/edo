<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Entity\Fragment;

/**
 * Class FragmentDTOTransformer
 * @package App\Component\Transformer
 */
class FragmentDTOTransformer
{
    /**
     * @param array $narrative
     * @return FragmentDTO
     */
    public static function createEmbeddedFragmentFromSingleSQL(array $narrative)
    {
        $fragmentDTO = new FragmentDTO();
        $fragmentDTO->setTitle($narrative['title']);
        $fragmentDTO->setContent($narrative['content']);
        $fragmentDTO->setUuid($narrative['uuid']);
        $fragmentDTO->setCreatedAt($narrative['created_at']);
        $fragmentDTO->setUuid($narrative['fragment_uuid']);

        return $fragmentDTO;
    }

    public static function toEntity(NarrativeDTO $narrativeDTO)
    {
        $fragment = new Fragment();
        $fragment->setTitle($narrativeDTO->getTitle());
        $fragment->setContent($narrativeDTO->getContent());

        return $fragment;
    }

}