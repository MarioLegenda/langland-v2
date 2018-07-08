<?php

namespace App\Infrastructure\Machine\Type\GameType;

use App\Infrastructure\Machine\Type\NamedTypeInterface;
use App\Infrastructure\Machine\Type\ScalarType\StringType;

class BasicGameType extends StringType implements NamedTypeInterface
{
    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'basic_game';
    }
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'Basic word guessing game';
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::getType();
    }
}