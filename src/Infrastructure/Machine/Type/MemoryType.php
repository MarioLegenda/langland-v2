<?php

namespace App\Infrastructure\Machine\Type;

use Library\Infrastructure\Type\BaseType;

class MemoryType extends BaseType implements NamedTypeInterface
{
    /**
     * @var array $types
     */
    protected static $types = [
        'short_term',
        'long_term',
        'in_between',
    ];
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'memory';
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::getName();
    }
}