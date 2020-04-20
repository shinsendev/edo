<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Origin\GetItem;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;

class OriginDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        $narrativesDTO = $config->getData()['narrativesDTO'];

        foreach ($narrativesDTO as $narrativeDTO) {
            // the parent of the family
            if ($narrativeDTO->getLvl() === 0) {
                foreach ($narrativeDTO->getChildren() as $child) {

                }
            }
        }
        // TODO: Implement proceed() method.
        return $narratives;
    }
}