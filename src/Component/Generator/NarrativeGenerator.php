<?php

declare(strict_types=1);

namespace App\Component\Generator;

use App\Component\DTO\NarrativeDTO;
use App\Entity\Fragment;
use App\Entity\Narrative;

/**
 * Class NarrativeTestGenerator
 * @package App\Tests\Helper
 */
class NarrativeGenerator implements GeneratorInterface
{
    /**
     * @return Narrative
     * @throws \Exception
     */
    public static function generate()
    {
        $narrative = new Narrative();
        $narrative->setUuid('76144aa9-407d-41d6-b970-13ead25c4770');

        return $narrative;
    }
}