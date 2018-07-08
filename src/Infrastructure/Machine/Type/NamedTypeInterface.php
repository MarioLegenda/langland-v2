<?php

namespace App\Infrastructure\Machine\Type;

interface NamedTypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string;
}