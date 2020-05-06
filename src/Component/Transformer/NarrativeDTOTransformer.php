<?php


namespace App\Component\Transformer;

use App\Component\DTO\Model\DTOInterface;
use App\Component\DTO\Model\NarrativeDTO;
use App\Component\DTO\Tree\PositionConvertor;
use App\Component\Error\EdoError;
use App\Component\Exception\EdoException;
use App\Entity\Abstraction\AbstractBaseEntity;
use App\Entity\Fiction;
use App\Entity\Fragment;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NarrativeDTOTransformer implements TransformerInterface
{
    /**
     * @param DTOInterface $narrativeDTO
     * @param EntityManagerInterface $em
     * @param AbstractBaseEntity|null $fragment
     * @return array|mixed
     * @throws EdoException
     */
    public static function toEntity(
        DTOInterface $narrativeDTO,
        EntityManagerInterface $em,
        AbstractBaseEntity $fragment = null
    )
    {
        // check if it is a narrative creation or an update
        $isCreation = self::isCreate($fragment);

        // if it's a creation, we set a new narrative
        if($isCreation) {
            $fragment = new Fragment();
        }

        // set Narrative Uuid
        $fragment = self::setNarrativeUuid($narrativeDTO, $fragment, $isCreation);

        // create position
        $position = self::createPosition($narrativeDTO, $isCreation, $fragment, $em);

        // set parent position
        $position = self::setParentPosition($narrativeDTO, $position, $em);

        // add fiction
        $fragment = self::setNarrativeFiction($narrativeDTO, $fragment, $em);

        // create result
        return self::createResponse($fragment, $position);
    }

    /**
     * @param AbstractBaseEntity|null $fragment
     * @return bool
     */
    public static function isCreate(?AbstractBaseEntity $fragment)
    {
        $isCreation = false;

        if(!$fragment) {
            $isCreation = true;
        }

        return $isCreation;
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param Fragment $fragment
     * @param bool $isCreation
     * @return Fragment
     */
    public static function setNarrativeUuid(DTOInterface $narrativeDTO, Fragment $fragment, bool $isCreation): Fragment
    {
        if ($isCreation) {
            $fragment->setUuid($narrativeDTO->getUuid());
        }

        return $fragment;
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param bool $isCreation
     * @param Fragment $fragment
     * @param EntityManagerInterface $em
     * @return Position|null
     * @throws \Exception
     */
    public static function createPosition (
        DTOInterface $narrativeDTO,
        bool $isCreation,
        Fragment $fragment,
        EntityManagerInterface $em
    )
    {
        $narrativeUuid = $narrativeDTO->getUuid();

        // get narrative's position
        if ($isCreation) { // if it is a new narrative we create the position
            $position = new Position();
            $position->setNarrative($fragment);
        }
        else { // if it is an update, we get the position of the narrative
            if (!$position = $em->getRepository(Position::class)->findOneByNarrative($fragment)) {
                throw new NotFoundHttpException('No position for the narrative '.$narrativeUuid);
            }
        }

        return $position;
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param Position $position
     * @param EntityManagerInterface $em
     * @return Position
     */
    public static function setParentPosition(DTOInterface $narrativeDTO, Position $position, EntityManagerInterface $em)
    {
        // parentUUid is the narrative parent uuid
        if ($parentUuid = $narrativeDTO->getParentUuid()) {

            // get parent's position : we need to find the corresponding position for the narrative uuid
            $parentNarrative = $em->getRepository(Fragment::class)->findOneByUuid($parentUuid);

            if (!$parentPosition = $em->getRepository(Position::class)->findOneByNarrative($parentNarrative)) {
                throw new NotFoundHttpException('No parent narrative for the uuid '.$narrativeDTO->getUuid());
            }

            $position->setParent($parentPosition);
        }

        return $position;
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param Fragment $fragment
     * @param EntityManagerInterface $em
     * @return Fragment
     * @throws EdoException
     */
    public static function setNarrativeFiction(DTOInterface $narrativeDTO, Fragment $fragment, EntityManagerInterface $em)
    {
        try {
            $fictionUuid = $narrativeDTO->getFictionUuid();
        } catch(\Error $e) {
            throw new EdoException('No uuid found for the fiction : ' . $e);
        }
        $fragment->setFiction($em->getRepository(Fiction::class)->findOneByUuid($fictionUuid));

        return $fragment;
    }

    /**
     * @param Fragment $fragment
     * @param Position|null $position
     * @return array
     */
    public static function createResponse(Fragment $fragment, ?Position $position)
    {
        $response = ['fragment' => $fragment];
        if ($position) {
            $response['position'] = $position;
        }
        return $response;
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

            // add datetime infos
            $narrativeDTO->setCreatedAt(($narrative->getCreatedAt())->format('Y-m-d H:i:s'));
            $narrativeDTO->setUpdatedAt(($narrative->getUpdatedAt())->format('Y-m-d H:i:s'));

            // set tree infos
            if ($config->getOptions() && isset ($config->getOptions()['position'])) {
                $position = $config->getOptions()['position'];

                if(isset($config->getOptions()['tree'])) {
                    $tree = $config->getOptions()['tree'];
                    $narrativeDTO->setRoot($tree['rootNarrativeUuid']);
                    if ($position->getParent()) {
                        $narrativeDTO->setParentUuid($tree['parentNarrativeUuid']);
                    }
                }

                $narrativeDTO->setLft($position->getLft());
                $narrativeDTO->setLvl($position->getLvl());
                $narrativeDTO->setRgt($position->getRgt());

                $narrativeDTO = self::setChildrenPosition($narrativeDTO, $position, $config->getEm());

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
            throw new EdoError('Error in fromEntity() from the NarrativeDTOTransformer');
        }
    }

    /**
     * @param DTOInterface $narrativeDTO
     * @param Position $position
     * @param EntityManagerInterface $em
     * @return DTOInterface
     */
    public static function setChildrenPosition(DTOInterface $narrativeDTO, Position $position, EntityManagerInterface $em)
    {
        $children = [];

        foreach ($position->getChildren() as $child) {
            // we add the corresponding narrative uuid for each position
            $children[] = PositionConvertor::getNarrativeUuid($child, $em);
        }

        $narrativeDTO->setChildren($children);

        return $narrativeDTO;
    }
}