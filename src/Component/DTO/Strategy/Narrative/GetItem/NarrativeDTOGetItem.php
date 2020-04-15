<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\DTO\Tree\PositionConvertor;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Narrative;
use App\Entity\Position;

/**
 * Class NarrativeDTOGetItem
 * @package App\Component\DTO\Strategy\Narrative
 */
class NarrativeDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $strategyConfig)
    {
        /** @var Narrative $narrative */
        $narrative = $strategyConfig->getEntity();

        /** @var Position $position */
        $position = $strategyConfig->getEm()->getRepository(Position::class)->findOneByNarrative($narrative);

        // set tree
        $parentNarrativeUUid =  null;
        if ($position->getParent()) {
            $parentNarrativeUUid = PositionConvertor::getNarrativeUuid($position->getParent(), $strategyConfig->getEm());
        }

        $tree = [
            'parentNarrativeUuid' => $parentNarrativeUUid,
            'rootNarrativeUuid' => PositionConvertor::getNarrativeUuid($position->getRoot(), $strategyConfig->getEm()),
        ];

        //convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity(
            NarrativeDTOGetItemHelper::createTransformerConfig(
                $strategyConfig->getEm(),
                $narrative,
                [
                    'position' => $position,
                    'tree' => $tree
                ]
            ));
    }
}