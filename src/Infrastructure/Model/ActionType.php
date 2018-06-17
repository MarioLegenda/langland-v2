<?php

namespace Infrastructure\Model;

use Library\Infrastructure\Type\BaseType;

class ActionType extends BaseType
{
    protected static $types = [
        'create',
        'update',
        'remove',
    ];
}