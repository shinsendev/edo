<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Narrative;

class NarrativeDTOGetItemFromCollection implements DTOStrategyInterface
{
    /**
     * @param DTOStrategyConfig $strategyConfig
     * @return \App\Component\DTO\Model\NarrativeDTO
     * @throws \App\Component\Exception\EdoException
     */
    public function proceed(DTOStrategyConfig $strategyConfig)
    {
        /** @var Narrative $narrative */
        $narrative = $strategyConfig->getEntity();

        //convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity(
            NarrativeDTOGetItemHelper::createTransformerConfig($strategyConfig->getEm(),
                $narrative,
                ['hideVersioning' => true]
            ));
    }
}