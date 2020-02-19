<?php


namespace App\Entity\Abstraction;

use App\Component\Transformer\TransformableInterface;
use App\Entity\EntityInterface;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractUniqueEntity
 * @package App\Entity\Abstraction
 *
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractUniqueEntity extends AbstractBaseEntity implements EntityInterface, TransformableInterface
{
    /**
     * @ORM\Column(type="guid", unique=true)
     *
     */
    protected $uuid;

    /**
     * BaseTrait constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $uuidGenerator = Uuid::uuid4();
        $this->setUuid($uuidGenerator->toString());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

}