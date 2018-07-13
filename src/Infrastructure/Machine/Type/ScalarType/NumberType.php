<?php

namespace App\Infrastructure\Machine\Type\ScalarType;

use Library\Infrastructure\Type\BaseType;
use Library\Infrastructure\Type\TypeInterface;

class NumberType extends BaseType
{
    /**
     * @var array $types
     */
    protected static $types = [];
    /**
     * @param mixed $value
     * @return TypeInterface
     */
    public static function fromValue($value): TypeInterface
    {
        static::$types[] = $value;

        if (is_int($value)) {
            return parent::fromValue((int) $value);
        }

        if (is_numeric($value)) {
            return parent::fromValue((int) $value);
        }

        throw new \RuntimeException(sprintf('%s could not be created from value %s', static::class, (string) $value));
    }
}