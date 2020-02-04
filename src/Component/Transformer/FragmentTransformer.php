<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\DTO\FragmentDTO;

/**
 * Class FragmentTransformer
 * @package App\Component\Transformer
 */
class FragmentTransformer
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
}