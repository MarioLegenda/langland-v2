<?php

namespace App\Infrastructure\Machine\Type;

use Library\Infrastructure\Type\BaseType;

class StressfulJobType extends BaseType implements NamedTypeInterface
{
    /**
     * @var array $types
     */
    protected static $types = [
        'stressful_job',
        'nonstressful_job',
    ];
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'stressful_job';
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::getName();
    }
}