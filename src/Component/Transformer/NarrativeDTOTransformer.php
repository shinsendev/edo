<?php


namespace App\Component\Transformer;


use App\Component\DTO\Model\AbstractDTO;
use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\Date\DateTimeHelper;
use App\Component\Exception\EdoException;
use App\Entity\Abstraction\AbstractBaseEntity;
use App\Entity\EntityInterface;
use App\Entity\Fiction;
use App\Entity\Narrative;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NarrativeDTOTransformer implements TransformerInterface
{
    /**
     * @param DTOInterface $narrativeDTO
     * @param EntityManagerInterface $em
     * @param AbstractBaseEntity|null $narrative
     * @return array|mixed
     * @throws EdoException
     */
    public static function toEntity(DTOInterface $narrativeDTO, EntityManagerInterface $em, AbstractBaseEntity $narrative = null)
    {
        // to check if it is a narrative creation or an update
        $isCreation = false;

        if(!$narrative) {
            $narrative = new Narrative();
            $isCreation = true;
        }

        try {
            $narrativeUuid = $narrativeDTO->getUuid();
        } catch(\Exception $e) {
            throw new EdoException('No uuid found for the narrative : ' . $e);
        }
        $narrative->setUuid($narrativeUuid);

        // parentUUid is narrative uuid
        if ($parentUuid = $narrativeDTO->getParentUuid()) {

            // get narrative's position, if it is a new narrative we create the position
            if ($isCreation) {
                $position = new Position();
                $position->setNarrative($narrative);
            }
            else {
                if (!$position = $em->getRepository(Position::class)->findOneByNarrative($narrative)) {
                    throw new NotFoundHttpException('No position for the narrative '.$narrativeUuid);
                }
            }

            // get parent's position : we need to find the corresponding position for the narrative uuid
            $parentNarrative = $em->getRepository(Narrative::class)->findOneByUuid($parentUuid);

            if (!$parentPosition = $em->getRepository(Position::class)->findOneByNarrative($parentNarrative)) {
                throw new NotFoundHttpException('No parent narrative for the uuid '.$narrativeUuid);
            }

            $position->setParent($parentPosition);
        }

        // add fiction
        try {
            $fictionUuid = $narrativeDTO->getFictionUuid();
        } catch(\Error $e) {
            throw new EdoException('No uuid found for the fiction : ' . $e);
        }

        $narrative->setFiction($em->getRepository(Fiction::class)->findOneByUuid($fictionUuid));

        $result = ['narrative' => $narrative];
        if (isset($position)) {
            $result['position'] = $position;
        }

        return $result;
    }

    /**
     * @param TransformerConfig $config
     *
     * @return NarrativeDTO
     * @throws EdoException
     */
    public static function fromEntity(TransformerConfig $config): NarrativeDTO
    {
        try {
            // create DTO and add basics
            $narrativeDTO = new NarrativeDTO();
            $narrative = $config->getSource();
            $narrativeDTO->setUuid($narrative->getUuid());

            // todo: to replace with dynamic data // do we still need the type?
            $narrativeDTO->setType('narrative');
            $narrativeDTO->setFictionUuid($narrative->getFiction()->getUuid());

            // add datetimes infos
            $narrativeDTO->setCreatedAt(($narrative->getCreatedAt())->format('Y-m-d H:i:s'));
            $narrativeDTO->setUpdatedAt(($narrative->getUpdatedAt())->format('Y-m-d H:i:s'));

            // set tree infos
            if ($config->getOptions() && isset ($config->getOptions()['position'])) {
                $position = $config->getOptions()['position'];
                $narrativeDTO->setRoot($position->getRoot()->getUuid());
                if ($position->getParent()) {
                    $narrativeDTO->setParentUuid($position->getParent()->getUuid());
                }
                $narrativeDTO->setLft($position->getLft());
                $narrativeDTO->setLvl($position->getLvl());
                $narrativeDTO->setRgt($position->getRgt());
            }

            $fragments = [];
            $nested = $config->getNested();

            // if there are nested fragments we use them to set the title and content of the narrative
            if ($nested) {
                // we set the content with the last fragment
                $narrativeDTO->setContent($nested['fragments'][0]->getContent());
            }

            // if it's not for the narratives collection, we add the last X fragments for the narrative
            if ($config->getOptions() && isset($config->getOptions()['hideVersioning'])) {
                if ($config->getOptions()['hideVersioning']) {
                    return $narrativeDTO;
                }
            }

            // if it's not a nested narrative, we add the fragments to DTO
            foreach ($nested['fragments'] as $fragment) {
               $fragments[] = FragmentDTOTransformer::fromEntity(new TransformerConfig($fragment));
            }
            $narrativeDTO->setFragments($fragments);

            return $narrativeDTO;
        } catch (\Error $e) {
            throw new EdoException('Error in the NarrativeDTOTransformer');
        }
    }
}