<?php

namespace App\Infrastructure\Machine\Type;

use Library\Infrastructure\Type\BaseType;

class ChallengesType extends BaseType implements NamedTypeInterface
{
    /**
     * @var array $types
     */
    protected static $types = [
        'likes_challenges',
        'dislike_challenges',
    ];
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'challenges';
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::getName();
    }
}