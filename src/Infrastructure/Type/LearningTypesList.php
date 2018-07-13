<?php

namespace App\Infrastructure\Type;

class LearningTypesList
{
    /**
     * @return array
     */
    public function getValueList(): array
    {
        /** @var LearningType $learningType */
        $learningType = LearningType::fromValue('Beginner');

        return $learningType->getTypes();
    }
    /**
     * @return array
     */
    public function getKeyList(): array
    {
        /** @var LearningType $learningType */
        $learningType = LearningType::fromValue('Beginner');

        return $learningType->getKeys();
    }
}