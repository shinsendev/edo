<?php

declare(strict_types=1);

namespace App\Component\Generator;

use App\Component\Date\DateTimeHelper;
use App\Entity\Fragment;
use Ramsey\Uuid\Uuid;

/**
 * Class FragmentTextGenerator
 * @package App\Component\Generator
 */
class FragmentGenerator
{
    /**
     * @Description generate fragment for existing narrative
     *
     * @param $narrativeUuid
     *
     * @return Fragment
     * @throws \Exception
     */
    public static function generateFragment($narrativeUuid)
    {
        $fragment = new Fragment();
        $fragment->setUuid(Uuid::uuid4());
        $fragment->setTitle('Title for '.$narrativeUuid);
        $fragment->setContent('Content for '.$narrativeUuid);
        $fragment->setCreatedAt(DateTimeHelper::now());

        return $fragment;
    }
}