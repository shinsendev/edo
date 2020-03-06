<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Narrative\Save;

use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\EntityManager\SaveEntityHelper;
use App\Component\Fragment\FragmentSaver;
use App\Component\Response\NarrativeResponseHelper;
use App\Component\Transformer\NarrativeDTOTransformer;
use Doctrine\ORM\EntityManagerInterface;

class NarrativeDTOSave implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        /** @var NarrativeDTO $dto */
        $dto = $config->getDto();

        /** @var EntityManagerInterface $em */
        $em = $config->getEm();

        $narrative = NarrativeDTOTransformer::toEntity($dto, $em);
        SaveEntityHelper::saveEntity($config->getEm(), $narrative);
        FragmentSaver::save($config->getEm(), $dto);

        return NarrativeResponseHelper::createResponse($config->getDto(), $narrative);
    }

}