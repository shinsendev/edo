<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Origin\GetItem;

use App\Component\DTO\Model\FragmentDTO;
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
        $fragmentsDTOList = $config->getData()['fragmentsDTO'];
        $childrenDTO = null;
        $result = [];

        foreach ($fragmentsDTOList as  $key => $fragmentDTO) {
            // the parent of the family is lvl 0
            if ($fragmentDTO->getLvl() === 0) {
                $result = $this->createFragmentDTOWithChildren($fragmentsDTOList, $fragmentDTO, $key);
            }
        }

        return $result;
    }

    /**
     * @param array $narrativesDTOList
     * @param FragmentDTO $fragmentDTO
     * @param int $key
     * @return array
     */
    private function createFragmentDTOWithChildren(array $narrativesDTOList, FragmentDTO $fragmentDTO, int $key)
    {
        // todo: refacto with this function and continue with recursivity

            // we remove used DTO from array
            unset($narrativesDTOList[$key]);

            // we get the children uuid
            $this->currentChildrenUuid = $fragmentDTO->getChildren();

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
                $fragmentDTO->setChildren($childrenDTOPayload);
            }
            $result[] = $fragmentDTO;

            return $result;
    }

    /**
     * @param FragmentDTO $fragmentDTO
     * @return FragmentDTO
     */
    private function extractChildrenByUuid(FragmentDTO $fragmentDTO) {
        // it is a child we return the DTO
        if (in_array($fragmentDTO->getUuid(), $this->currentChildrenUuid)) {
            return $fragmentDTO;
        }
    }

}