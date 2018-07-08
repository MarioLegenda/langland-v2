<?php

namespace App\Infrastructure\Machine\Type\TypeList;

use App\Infrastructure\Machine\Type\ChallengesType;
use App\Infrastructure\Machine\Type\FreeTimeType;
use App\Infrastructure\Machine\Type\LearningTimeType;
use App\Infrastructure\Machine\Type\MemoryType;
use App\Infrastructure\Machine\Type\PersonType;
use App\Infrastructure\Machine\Type\ProfessionType;
use App\Infrastructure\Machine\Type\SpeakingLanguagesType;
use App\Infrastructure\Machine\Type\StressfulJobType;

class FrontendTypeList
{
    /**
     * @return array
     */
    public static function getList(): array
    {
        return [
            SpeakingLanguagesType::getName() => SpeakingLanguagesType::class,
            ProfessionType::getName() => ProfessionType::class,
            PersonType::getName() => PersonType::class,
            LearningTimeType::getName() => LearningTimeType::class,
            FreeTimeType::getName() => FreeTimeType::class,
            MemoryType::getName() => MemoryType::class,
            ChallengesType::getName() => ChallengesType::class,
            StressfulJobType::getName() => StressfulJobType::class,
        ];
    }
}