<?php

declare(strict_types=1);

namespace App\Component\DTO\Strategy\Narrative\Update;

use App\Component\Configuration\FragmentConfiguration;
use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Response\FragmentResponseHelper;
use App\Component\Response\NarrativeResponseHelper;
use App\Component\Transformer\FragmentDTOTransformer;
use App\Component\Transformer\VersionDTOTransformer;
use App\Component\Transformer\NarrativeDTOTransformer;
use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Entity\Version;
use Doctrine\ORM\EntityManager;

class FragmentDTOUpdate implements DTOStrategyInterface
{
    /** @var EntityManager */
    private $em;

    /** @var FragmentDTO */
    private $dto;

    /** @var Fragment */
    private $entity;

    /**
     * @param DTOStrategyConfig $config
     *
     * @return FragmentDTO
     * @throws \App\Component\Exception\EdoException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function proceed(DTOStrategyConfig $config)
    {
        // initialize all variables in the class
        $this->initialize($config);
        $updateResult = $this->updateFragment( $this->dto, $this->entity);
        SaveEntityHelper::saveEntity($this->em, $updateResult);

        // as long as there are more versions than authorized, we delete them one by one
        while ($this->countVersions($this->entity) >=  FragmentConfiguration::getMaxVersionning())
        {
            // delete oldest fragment and its qualification
            $this->deleteFragment($this->entity);
        }

        // we save the fragments
        SaveEntityHelper::saveEntity($this->em, VersionDTOTransformer::toEntity( $this->dto, $config->getEm()));

        return FragmentResponseHelper::createResponse($this->dto, $updateResult);
    }

    /**
     * @param FragmentDTO $dto
     * @param Fragment $fragment
     * @return array|mixed
     * @throws \App\Component\Exception\EdoException
     */
    private function updateFragment(FragmentDTO $dto, Fragment $fragment)
    {
        // update parent with $narrativeDTO
        $result = FragmentDTOTransformer::toEntity($dto, $this->em, $fragment);

        // update updatedAt
        ($result['fragment'])->setUpdatedAt(DateTimeHelper::now());

        // save narrative
        SaveEntityHelper::saveEntity($this->em, $result);

        return $result;
    }

    /**
     * @param Fragment $fragment
     * @return int
     */
    public function countVersions(Fragment $fragment)
    {
        return $this->em->getRepository(Version::class)->countFragmentVersions($fragment->getUuid());
    }

    /**
     * @param Fragment $fragment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteFragment(Fragment $fragment)
    {
        $oldestVersionUuid =  $this->em->getRepository(Version::class)->findOldestVersionUuid($fragment->getUuid());
        $oldestVersion =  $this->em->getRepository(Version::class)->findOneByUuid($oldestVersionUuid);
        $this->em->remove($oldestVersion);
        $this->em->flush();
    }

    /**
     * @param DTOStrategyConfig $config
     */
    private function initialize(DTOStrategyConfig $config)
    {
        $this->em = $config->getEm();
        $this->dto = $config->getDto();
        $this->entity = $config->getData()['fragment'];
    }

}