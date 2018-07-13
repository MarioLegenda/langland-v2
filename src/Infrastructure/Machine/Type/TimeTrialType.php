<?php

namespace App\Infrastructure\Machine\Type;

use Library\Infrastructure\Type\BaseType;

class TimeTrialType extends BaseType
{
    protected static $types = [
        0 => 3,
        1 => 5,
        2 => 10,
    ];
}