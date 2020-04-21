<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\DTO\Tree\PositionConvertor;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Narrative;
use App\Entity\Position;

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
        $narrative = $strategyConfig->getData()['narrative'];

        /** @var Position $position */
        $position = $strategyConfig->getEm()->getRepository(Position::class)->findOneByNarrative($narrative);

        // set tree
        $parentNarrativeUUid =  null;
        if ($position->getParent()) {
            $parentNarrativeUUid = PositionConvertor::getNarrativeUuid($position->getParent(), $strategyConfig->getEm());
        }

        // we use narrative uuid in DTO, not the position Uuid
        $tree = [
            'parentNarrativeUuid' => $parentNarrativeUUid,
            'rootNarrativeUuid' => PositionConvertor::getNarrativeUuid($position->getRoot(), $strategyConfig->getEm()),
        ];

        //convert narrative into Narrative DTO
        return NarrativeDTOTransformer::fromEntity(
            NarrativeDTOGetItemHelper::createTransformerConfig($strategyConfig->getEm(),
                $narrative,
                [
                    'hideVersioning' => true,
                    'position' => $position,
                    'tree' => $tree
                ]
            ));
    }
}