<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\StringType;

class GetHttpType extends StringType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'get',
    ];
}