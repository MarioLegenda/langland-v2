<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\StringType;

class PatchHttpType extends StringType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'patch',
    ];
}