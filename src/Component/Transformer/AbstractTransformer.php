<?php

declare(strict_types=1);


namespace App\Component\Transformer;

/**
 * Class AbstractDTOTransformer
 * @package App\Component\Transformer
 */
class AbstractTransformer
{
    public function supports($data, $target)
    {
        return $data instanceof $target;
    }
}