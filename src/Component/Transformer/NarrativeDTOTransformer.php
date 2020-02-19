<?php


namespace App\Component\Transformer;


use App\Component\DTO\DTOInterface;
use App\Component\DTO\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\Exception\EdoException;
use App\Entity\EntityInterface;
use App\Entity\Fiction;
use App\Entity\Narrative;
use Doctrine\ORM\EntityManagerInterface;

class NarrativeDTOTransformer implements TransformerInterface
{
    /**
     * @param DTOInterface $narrativeDTO
     * @param EntityManagerInterface $em
     * @return Narrative
     * @throws \Exception
     */
    public static function toEntity(DTOInterface $narrativeDTO, EntityManagerInterface $em)
    {
        $narrative = new Narrative();

        try {
            $narrativeUuid = $narrativeDTO->getUuid();
        } catch(\Exception $e) {
            throw new EdoException('No uuid found for the narrative : ' . $e);
        }
        $narrative->setUuid($narrativeUuid);

        // set datetimes
        $narrative->setCreatedAt(DateTimeHelper::now());
        $narrative->setUpdatedAt(DateTimeHelper::now());

        //todo : implement tree mapping, only the parent?

        // add fiction
        try {
            $fictionUuid = $narrativeDTO->getFictionUuid();
        } catch(\Error $e) {
            throw new EdoException('No uuid found for the fiction : ' . $e);
        }

        $narrative->setFiction($em->getRepository(Fiction::class)->findOneByUuid($fictionUuid));

        return $narrative;
    }

    /**
     * @param TransformerConfig $config
     *
     * @return NarrativeDTO
     * @throws EdoException
     */
    public static function fromEntity(TransformerConfig $config): NarrativeDTO
    {
        // create DTO and add basics
        $narrativeDTO = new NarrativeDTO();
        $narrative = $config->getSource();
        $narrativeDTO->setUuid($narrative->getUuid());
        $narrativeDTO->setFictionUuid($narrative->getFiction()->getUuid());

        // add datetimes infos
        $narrativeDTO->setCreatedAt(($narrative->getCreatedAt())->format('Y-m-d H:i:s'));
        $narrativeDTO->setUpdatedAt(($narrative->getUpdatedAt())->format('Y-m-d H:i:s'));

        // set tree info
        $narrativeDTO->setRoot($narrative->getRoot()->getUuid());
        if ($narrative->getParent()) {
            $narrativeDTO->setParent($narrative->getParent()->getUuid());
        }
        $narrativeDTO->setLft($narrative->getLft());
        $narrativeDTO->setLvl($narrative->getLvl());
        $narrativeDTO->setRgt($narrative->getRgt());


        $fragments = [];
        $nested = $config->getNested();

        // if there are nested fragments we use them to set the title and content of the narrative
        $narrativeDTO->setTitle($nested['fragments'][0]->getTitle());
        $narrativeDTO->setContent($nested['fragments'][0]->getContent());

        // if it's not for the narratives collection, we add the last X fragments for the narrative
        if ($config->getOptions() && isset($config->getOptions()['nested'])) {
            if ($config->getOptions()['nested']) {
                return $narrativeDTO;
            }
        }

        // if it's not a nested narrative, we add the fagments to DTO
        foreach ($nested['fragments'] as $fragment) {
           $fragments[] = FragmentDTOTransformer::fromEntity(new TransformerConfig($fragment));
        }
        $narrativeDTO->setFragments($fragments);

        return $narrativeDTO;
    }
}