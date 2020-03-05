<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\Transformer\TransformerConfig;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DTOStrategyGETHelper
 * @package App\Component\DTO\Strategy\Helper
 */
class NarrativeDTOGetItemHelper
{
    /**
     * @param EntityManagerInterface $em
     * @param Narrative $narrative
     * @param array $options
     * @return TransformerConfig
     */
    public static function createTransformerConfig(EntityManagerInterface $em, Narrative $narrative, array $options = [])
    {
        return new TransformerConfig(
            $narrative,
            // we only keep the last fragment to set the title and the content
            ["fragments" => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid() ,10)],
            $em,
            $options
        );
    }
}