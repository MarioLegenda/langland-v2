<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\StringType;

class PostHttpType extends StringType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'post',
    ];
}