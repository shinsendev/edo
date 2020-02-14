<?php

declare(strict_types=1);

namespace App\Component\Transformer;

use App\Component\DTO\DTOInterface;
use App\Component\DTO\FragmentDTO;
use App\Component\DTO\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\Exception\EdoException;
use App\Entity\EntityInterface;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class FragmentDTOTransformer
 * @package App\Component\Transformer
 */
class FragmentDTOTransformer extends AbstractTransformer implements TransformerInterface
{
    public static function fromEntity(EntityInterface $fragment)
    {
        if(!$fragment instanceof Fragment)
        {
            throw new EdoException('Not a fragment');
        }

        $fragmentDTO = new FragmentDTO();
        $fragmentDTO->setTitle($fragment->getTitle());
        $fragmentDTO->setContent($fragment->getContent());
        $fragmentDTO->setCreatedAt(DateTimeHelper::stringify($fragment->getCreatedAt()));
        $fragmentDTO->setUuid($fragment->getUuid());

        return $fragmentDTO;
    }

    /**
     * @param array $source
     */
    static function fromArray(array $source)
    {
        // TODO: Implement fromArray() method.
    }


    //todo : correct not supposed to be Narrative DTO here
    public static function toEntity(DTOInterface $narrativeDTO, EntityManagerInterface $em)
    {
        if(!$narrativeDTO instanceof NarrativeDTO)
        {
            throw new EdoException('Not a narrative DTO');
        }

        $fragment = new Fragment();
        $fragment->setTitle($narrativeDTO->getTitle());
        $fragment->setContent($narrativeDTO->getContent());
        $fragment->setCreatedAt(DateTimeHelper::now());
        $fragment->setNarrative($em->getRepository(Narrative::class)->findOneByUuid($narrativeDTO->getUuid()));

        return $fragment;
    }

}