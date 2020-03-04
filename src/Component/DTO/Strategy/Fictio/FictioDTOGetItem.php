<?php

declare(strict_types=1);


namespace App\Component\DTO\Strategy\Fictio;


use App\Component\DTO\Strategy\DTOStrategyConfig;
use App\Component\DTO\Strategy\DTOStrategyInterface;
use App\Component\Transformer\FictionDTOTransformer;
use App\Component\Transformer\TransformerConfig;
use App\Entity\Character;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FictioDTOGetItem
 * @package App\Component\DTO\Strategy\Fictio
 */
class FictioDTOGetItem implements DTOStrategyInterface
{
    public function proceed(DTOStrategyConfig $config)
    {
        //initialize
        /** @var EntityManagerInterface $em */
        $em = $config->getEm();

        /** @var Fiction $fiction */
        $fiction = $config->getEntity();

        // prepare transformer conf
        $narratives = $em->getRepository(Narrative::class)->findByFiction($fiction);
        $origins = $em->getRepository(Narrative::class)->findOrigins($fiction, 3);
        $followings = $em->getRepository(Narrative::class)->findFollowings($fiction, 3);
        $characters = $em->getRepository(Character::class)->findLastCharacters($fiction);
        $nestedArray = ['narratives' => $narratives, 'origins' => $origins,  'followings' => $followings, 'characters' => $characters];
        $transformerConfig = new TransformerConfig($fiction, $nestedArray, $em);

        // convert entity narrative into Narrative DTO
        return FictionDTOTransformer::fromEntity($transformerConfig);
    }

}