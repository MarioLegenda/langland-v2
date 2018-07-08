<?php

namespace App\Infrastructure\Machine\Type;

class TimeTrialType extends BaseType
{
    protected static $types = [
        0 => 3,
        1 => 5,
        2 => 10,
    ];
}