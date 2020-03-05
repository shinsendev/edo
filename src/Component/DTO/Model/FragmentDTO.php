<?php

declare(strict_types=1);

namespace App\Component\DTO\Model;

use Symfony\Component\Validator\Constraints as Assert;
use App\Component\DTO\Composition\DatableTrait;
use Ramsey\Uuid\Uuid;

/**
 * Class Fragment
 * @package App\Component\DTO
 */
class FragmentDTO extends AbstractDTO
{
    use DatableTrait;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @Assert\Length(
     *      max = 1024,
     *      maxMessage = "Your content cannot be longer than {{ limit }} characters"
     * )
     */
    private $content;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}