<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Component\Transformer\TransformerConfig;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

class NarrativeDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        /** @var Narrative $narrative */
        $narrative = $config->getEntity();

        /** @var EntityManagerInterface $em */
        $em = $config->getEm();

        // convert narrative into Narrative DTO
        $config = new TransformerConfig(
            $narrative,
            // we only keep the last fragment to set the title and the content
            ["fragments" => $em->getRepository(Fragment::class)->findNarrativeLastFragments($narrative->getUuid() ,10)],
            $em
        );
        return NarrativeDTOTransformer::fromEntity($config);
    }
}