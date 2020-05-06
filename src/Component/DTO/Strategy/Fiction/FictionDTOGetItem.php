<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Fiction;

use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\Transformer\FictionDTOTransformer;
use App\Component\Transformer\TransformerConfig;
use App\Entity\Character;
use App\Entity\Fiction;
use App\Entity\Fragment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FictioDTOGetItem
 * @package App\Component\DTO\Strategy\Fictio
 */
class FictionDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        //initialize
        /** @var EntityManagerInterface $em */
        $em = $config->getEm();

        /** @var Fiction $fiction */
        $fiction = $config->getData()['fiction'];

        // prepare transformer conf
        $fragments = $em->getRepository(Fragment::class)->findByFiction($fiction);
        $origins = $em->getRepository(Fragment::class)->findOrigins($fiction, 3);
        $followings = $em->getRepository(Fragment::class)->findFollowings($fiction, 3);
        $characters = $em->getRepository(Character::class)->findLastCharacters($fiction);

        $nestedArray = ['fragments' => $fragments, 'origins' => $origins,  'followings' => $followings, 'characters' => $characters];
        $transformerConfig = new TransformerConfig($fiction, $nestedArray, $em);

        // convert entity narrative into Narrative DTO
        return FictionDTOTransformer::fromEntity($transformerConfig);
    }

}