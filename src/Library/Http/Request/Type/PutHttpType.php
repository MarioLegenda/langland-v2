<?php

namespace Library\Http\Request\Type;

use Library\Infrastructure\Type\StringType;

class PutHttpType extends StringType
{
    /**
     * @var array $types
     */
    protected $types = [
        'put',
    ];
}