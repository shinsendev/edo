<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\DTO\Tree\PositionConvertor;
use App\Component\Transformer\FragmentDTOTransformer;
use App\Entity\Fragment;
use App\Entity\Position;

/**
 * Class NarrativeDTOGetItem
 * @package App\Component\DTO\Strategy\Narrative
 */
class FragmentDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $strategyConfig)
    {
        /** @var Fragment $fragment */
        $fragment = $strategyConfig->getData()['fragment'];

        /** @var Position $position */
        $position = $strategyConfig->getEm()->getRepository(Position::class)->findOneByFragment($fragment);

        // set tree
        $parentFragmentUUid =  null;
        if ($position->getParent()) {
            $parentFragmentUUid = PositionConvertor::getFragmentUuid($position->getParent(), $strategyConfig->getEm());
        }

        // we use fragment uuid in DTO, not the position Uuid
        $tree = [
            'parentNarrativeUuid' => $parentFragmentUUid,
            'rootNarrativeUuid' => PositionConvertor::getFragmentUuid($position->getRoot(), $strategyConfig->getEm()),
        ];

        //convert fragment into fragment DTO
        return FragmentDTOTransformer::fromEntity(
            FragmentDTOGetItemHelper::createTransformerConfig(
                $strategyConfig->getEm(),
                $fragment,
                [
                    'position' => $position,
                    'tree' => $tree
                ]
            ));
    }
}