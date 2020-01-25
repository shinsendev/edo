<?php


namespace App\Component\Transformer;


use App\Component\DTO\FragmentOutputDTO;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class FragmentOutputTransformer
 * @package App\Component\Transformer
 */
final class FragmentOutputTransformer implements DataTransformerInterface
{
    public function transform($data) :?FragmentOutputDTO
    {
        $output = new FragmentOutputDTO();
        $output->setContent($data->content);

        return $output;
    }

    public function reverseTransform($value)
    {
        // TODO: Implement reverseTransform() method.
    }
}