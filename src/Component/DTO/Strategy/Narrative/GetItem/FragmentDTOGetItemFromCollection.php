<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\DTO\Tree\PositionConvertor;
use App\Component\Transformer\FragmentDTOTransformer;
use App\Entity\Fragment;
use App\Entity\Position;

class FragmentDTOGetItemFromCollection implements DTOStrategyInterface
{
    /**
     * @param DTOStrategyConfig $strategyConfig
     * @return \App\Component\DTO\Model\FragmentDTO
     * @throws \App\Component\Exception\EdoException
     */
    public function proceed(DTOStrategyConfig $strategyConfig)
    {
        /** @var Fragment $fragment */
        $fragment = $strategyConfig->getData()['fragment'];

        /** @var Position $position */
        $position = $strategyConfig->getEm()->getRepository(Position::class)->findOneByFragment($fragment);

        // set tree
        $parentNarrativeUUid =  null;
        if ($position->getParent()) {
            $parentNarrativeUUid = PositionConvertor::getFragmentUuid($position->getParent(), $strategyConfig->getEm());
        }

        // we use narrative uuid in DTO, not the position Uuid
        $tree = [
            'parentNarrativeUuid' => $parentNarrativeUUid,
            'rootNarrativeUuid' => PositionConvertor::getFragmentUuid($position->getRoot(), $strategyConfig->getEm()),
        ];

        //convert narrative into Narrative DTO
        return FragmentDTOTransformer::fromEntity(
            FragmentDTOGetItemHelper::createTransformerConfig($strategyConfig->getEm(),
                $fragment,
                [
                    'hideVersioning' => true,
                    'position' => $position,
                    'tree' => $tree
                ]
            ));
    }
}