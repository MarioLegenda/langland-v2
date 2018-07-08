<?php

namespace App\Infrastructure\Machine\Type;

use App\Infrastructure\Machine\Type\ScalarType\NumberType;

class SpeakingLanguagesType extends NumberType implements NamedTypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'speaking_languages';
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::getName();
    }
}