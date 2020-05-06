<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\Transformer\TransformerConfig;
use App\Entity\Fragment;
use App\Entity\Version;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DTOStrategyGETHelper
 * @package App\Component\DTO\Strategy\Helper
 */
class FragmentDTOGetItemHelper
{
    /**
     * @param EntityManagerInterface $em
     * @param Fragment $fragment
     * @param array $options
     * @return TransformerConfig
     */
    public static function createTransformerConfig(EntityManagerInterface $em, Fragment $fragment, array $options = [])
    {
        return new TransformerConfig(
            $fragment,
            // we only keep the last fragment to set the title and the content
            ["versions" => $em->getRepository(Version::class)->findFragmentLastVersions($fragment->getUuid() ,10)],
            $em,
            $options
        );
    }
}