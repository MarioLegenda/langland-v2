<?php

namespace App\Infrastructure\Type;

use Library\Infrastructure\Type\BaseType;

class LearningType extends BaseType
{
    /**
     * @var array $types
     */
    protected static $types = [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ];
    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->allTypes;
    }
    /**
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->allTypes);
    }
}