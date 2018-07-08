<?php

namespace App\Infrastructure\Machine\Type\ScalarType;

use App\Infrastructure\Machine\Type\BaseType;
use App\Infrastructure\Machine\Type\TypeInterface;

class NumberType extends BaseType
{
    /**
     * @param mixed $value
     * @return TypeInterface
     */
    public static function fromValue($value): TypeInterface
    {
        if (is_int($value)) {
            return new static([$value]);
        }

        if (is_numeric($value)) {
            return new static([(int) $value]);
        }

        throw new \RuntimeException(sprintf('%s could not be created from value %s', static::class, (string) $value));
    }
}