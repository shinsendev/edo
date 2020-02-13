<?php

declare(strict_types=1);

namespace App\Component\Generator;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fragment;
use App\Entity\Narrative;
use Ramsey\Uuid\Uuid;

/**
 * todo: implement the interface by using Entity and add a check instance
 *
 * Class FragmentTextGenerator
 * @package App\Component\Generator
 */
class FragmentGenerator
{
    /**
     * @Description generate fragment for existing narrative
     *
     * @param Narrative $narrative
     *
     * @return Fragment
     * @throws \Exception
     */
    public static function generate(Narrative $narrative): Fragment
    {
        $fragment = new Fragment();

        // let the possibility to manually add uuid
        $fragment->setUuid(Uuid::uuid4());
        $fragment->setTitle('Title for '.$narrative->getUuid());
        $fragment->setContent('Content for '.$narrative->getUuid());
        $fragment->setCreatedAt(DateTimeHelper::now());
        $fragment->setNarrative($narrative);

        return $fragment;
    }
}