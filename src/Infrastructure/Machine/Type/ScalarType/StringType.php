<?php

namespace App\Infrastructure\Machine\Type\ScalarType;

use Library\Infrastructure\Type\TypeInterface;
use Library\Infrastructure\Type\BaseType;

class StringType extends BaseType
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

        if (is_string($value)) {
            return parent::fromValue([$value]);
        }

        throw new \RuntimeException(sprintf('%s could not be created from value %s', static::class, (string) $value));
    }
}