<?php

namespace App\Infrastructure\Machine\Type;

use Library\Infrastructure\Type\BaseType;

class WordLevelType extends BaseType
{
    /**
     * @var array $types
     */
    protected static $types = [
        0 => 1,
        1 => 2,
        2 => 3,
        3 => 4,
        4 => 5,
    ];
}