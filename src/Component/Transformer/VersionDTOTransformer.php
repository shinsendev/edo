<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\DTO\Model\AbstractDTO;
use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\DTO\Model\VersionDTO;
use App\Component\Exception\EdoException;
use App\Entity\EntityInterface;
use App\Entity\Fragment;
use App\Entity\Narrative;
use App\Entity\Version;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class VersionDTOTransformer
 * @package App\Component\Transformer
 */
class VersionDTOTransformer extends AbstractTransformer implements TransformerInterface
{
    public static function fromEntity(TransformerConfig $config)
    {
        $version = $config->getSource();
        if(!$version instanceof Version)
        {
            throw new EdoException('Not a Version Entity.');
        }

        $versionDTO = new VersionDTO();
        $versionDTO->setContent($version->getContent());
        $versionDTO->setCreatedAt(DateTimeHelper::stringify($version->getCreatedAt()));
        $versionDTO->setUuid($version->getUuid());

        return $versionDTO;
    }

    //todo : correct not supposed to be Narrative DTO here
    public static function toEntity(DTOInterface $fragmentDTO, EntityManagerInterface $em)
    {
        // we check if it is the correct DTO
        if(!$fragmentDTO instanceof FragmentDTO)
        {
            throw new EdoException('Not a narrative DTO');
        }

        // check if narrative really exists
        if (!$fragment = $em->getRepository(Fragment::class)->findOneByUuid($fragmentDTO->getUuid())) {
            throw new EdoException('There are no Narrative '.$fragmentDTO->getUuid());
        }

        $version = new Version();
        $version->setContent($fragmentDTO->getContent());
        $version->setCreatedAt(DateTimeHelper::now());

        $version->setFragment($fragment);

        return ['version' => $version];
    }

}