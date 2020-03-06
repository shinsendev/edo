<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\Update;

use App\Component\Configuration\NarrativeConfiguration;
use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Response\NarrativeResponseHelper;
use App\Component\Transformer\FragmentDTOTransformer;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManager;

class NarrativeDTOUpdate implements DTOStrategyInterface
{
    /** @var EntityManager */
    private $em;

    /** @var NarrativeDTO */
    private $dto;

    /** @var Narrative */
    private $entity;

    /**
     * @param DTOStrategyConfig $config
     *
     * @return NarrativeDTO
     * @throws \App\Component\Exception\EdoException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function proceed(DTOStrategyConfig $config)
    {
        // initialize all variables in the class
        $this->initialize($config);

        $this->updateNarrative( $this->dto, $this->entity);
        SaveEntityHelper::saveEntity($this->em, $config->getEntity());
        // as long as there are more fragments than authorized, we delete them one by one
        while ($this->countFragments($this->entity) >=  NarrativeConfiguration::getMaxVersionningFragments())
        {
            // delete oldest fragment and its qualification
            $this->deleteFragment($this->entity);
        }

        // we save the fragments
        SaveEntityHelper::saveEntity($this->em, FragmentDTOTransformer::toEntity( $this->dto, $config->getEm()));

        return NarrativeResponseHelper::createResponse($this->dto, $this->entity);
    }

    /**
     * @param NarrativeDTO $dto
     * @param Narrative $narrative
     * @throws \Exception
     */
    private function updateNarrative(NarrativeDTO $dto, Narrative $narrative)
    {
        // update parent with $narrativeDTO
        $narrative = NarrativeDTOTransformer::toEntity($dto, $this->em, $narrative);

        // update updatedAt
        $narrative->setUpdatedAt(DateTimeHelper::now());

        // save narrative
        SaveEntityHelper::saveEntity($this->em, $narrative);
    }

    /**
     * @param Narrative $narrative
     * @return int
     */
    public function countFragments(Narrative $narrative)
    {
        return $this->em->getRepository(Fragment::class)->countNarrativeFragments($narrative->getUuid());
    }

    /**
     * @param Narrative $narrative
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteFragment(Narrative $narrative)
    {
        $arrayLastFragment =  $this->em->getRepository(Fragment::class)->findNarrativeLastFragment($narrative->getUuid());
        $lastFragment =  $this->em->getRepository(Fragment::class)->findOneByUuid($arrayLastFragment['uuid']);
        $this->em->remove($lastFragment);
        $this->em->flush();
    }

    /**
     * @param DTOStrategyConfig $config
     */
    private function initialize(DTOStrategyConfig $config)
    {
        $this->em = $config->getEm();
        $this->dto = $config->getDto();
        $this->entity = $config->getEntity();
    }

}