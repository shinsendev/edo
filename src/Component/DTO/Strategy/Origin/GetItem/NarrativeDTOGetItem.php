<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Origin\GetItem;

use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;

class NarrativeDTOGetItem implements DTOStrategyInterface
{
    /** @var array  */
    private $currentChildrenUuid = [];

    /**
     * @param DTOStrategyConfig $config
     * @return array
     */
    public function proceed(DTOStrategyConfig $config)
    {
        $narrativesDTOList = $config->getData()['narrativesDTO'];
        $childrenDTO = null;
        $result = [];

        foreach ($narrativesDTOList as  $key => $narrativeDTO) {
            // the parent of the family is lvl 0
            if ($narrativeDTO->getLvl() === 0) {
                $result = $this->createFragmentDTOWithChildren($narrativesDTOList, $narrativeDTO, $key);
            }
        }

        return $result;
    }

    /**
     * @param array $narrativesDTOList
     * @param NarrativeDTO $narrativeDTO
     * @param int $key
     * @return array
     */
    private function createFragmentDTOWithChildren(array $narrativesDTOList, NarrativeDTO $narrativeDTO, int $key)
    {
        // todo: refacto with this function and continue with recursivity

            // we remove used DTO from array
            unset($narrativesDTOList[$key]);

            // we get the children uuid
            $this->currentChildrenUuid = $narrativeDTO->getChildren();

            // we get the narrativesDTO with the children uuid
            $childrenDTO = array_filter($narrativesDTOList, [ $this, 'extractChildrenByUuid' ]);

            // for each of this narratives uuid, we remove them from the narrative DTO list and we convert them in better format for payload
            if ($childrenDTO) {
                $childrenDTOPayload = [];
                foreach ($childrenDTO as $key => $childDTO) {
                    // clean list
                    unset($narrativesDTOList[$key]);

                    // payload children reformat
                    $childrenDTOPayload[] = $childDTO;

                    // we recursively call the function when children exist and for each child
                    $this->createFragmentDTOWithChildren($narrativesDTOList, $childDTO, $key);
                }
                $narrativeDTO->setChildren($childrenDTOPayload);
            }
            $result[] = $narrativeDTO;

            return $result;
    }

    /**
     * @param NarrativeDTO $narrativesDTO
     * @return NarrativeDTO
     */
    private function extractChildrenByUuid(NarrativeDTO $narrativesDTO) {
        // it is a child we return the DTO
        if (in_array($narrativesDTO->getUuid(), $this->currentChildrenUuid)) {
            return $narrativesDTO;
        }
    }

}