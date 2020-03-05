<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\DTO\Model\AbstractDTO;
use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\FragmentDTO;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\Exception\EdoException;
use App\Entity\EntityInterface;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FragmentDTOTransformer
 * @package App\Component\Transformer
 */
class FragmentDTOTransformer extends AbstractTransformer implements TransformerInterface
{
    public static function fromEntity(TransformerConfig $config)
    {
        $fragment = $config->getSource();
        if(!$fragment instanceof Fragment)
        {
            throw new EdoException('Not a fragment');
        }

        $fragmentDTO = new FragmentDTO();
        $fragmentDTO->setContent($fragment->getContent());
        $fragmentDTO->setCreatedAt(DateTimeHelper::stringify($fragment->getCreatedAt()));
        $fragmentDTO->setUuid($fragment->getUuid());

        return $fragmentDTO;
    }

    //todo : correct not supposed to be Narrative DTO here
    public static function toEntity(DTOInterface $narrativeDTO, EntityManagerInterface $em)
    {
        // we check if it is the correct DTO
        if(!$narrativeDTO instanceof NarrativeDTO)
        {
            throw new EdoException('Not a narrative DTO');
        }

        // check if narrative really exists
        if (!$narrative = $em->getRepository(Narrative::class)->findOneByUuid($narrativeDTO->getUuid())) {
            throw new EdoException('There are no Narrative '.$narrativeDTO->getUuid());
        }

        $fragment = new Fragment();
        $fragment->setContent($narrativeDTO->getContent());
        $fragment->setCreatedAt(DateTimeHelper::now());

        $fragment->setNarrative($narrative);
        return $fragment;
    }

}