<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class IntegerToBooleanTransformer implements DataTransformerInterface
{
    public function transform($value): mixed
    {
        // Transform 1 or 0 to boolean
        return (bool)$value;
    }

    public function reverseTransform($value): mixed
    {
        // Transform boolean to 1 or 0
        return $value ? 1 : 0;
    }
}
