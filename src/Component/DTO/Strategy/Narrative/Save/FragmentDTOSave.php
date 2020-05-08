<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Narrative\Save;

use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Response\FragmentResponseHelper;
use App\Component\Transformer\FragmentDTOTransformer;
use Doctrine\ORM\EntityManagerInterface;

class FragmentDTOSave implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        /** @var FragmentDTO $dto */
        $dto = $config->getDto();

        /** @var EntityManagerInterface $em */
        $em = $config->getEm();

        $narrativeResponse = FragmentDTOTransformer::toEntity($dto, $em);
        SaveEntityHelper::saveEntity($config->getEm(), $narrativeResponse);
        FragmentSaver::save($config->getEm(), $dto);

        return FragmentResponseHelper::createResponse($config->getDto(), $narrativeResponse);
    }

}