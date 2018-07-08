<?php

namespace App\Tests\Unit;

use App\Infrastructure\Machine\Type\ChallengesType;
use App\Infrastructure\Machine\Type\FreeTimeType;
use App\Infrastructure\Machine\Type\LearningTimeType;
use App\Infrastructure\Machine\Type\MemoryType;
use App\Infrastructure\Machine\Type\PersonType;
use App\Infrastructure\Machine\Type\ProfessionType;
use App\Infrastructure\Machine\Type\SpeakingLanguagesType;
use App\Infrastructure\Machine\Type\StressfulJobType;
use App\Infrastructure\Machine\Type\TypeList\FrontendTypeList;
use App\Infrastructure\Machine\QuestionAnswers;
use App\Infrastructure\Machine\QuestionToTypeConverter;
use App\Tests\Library\BasicSetup;

class QuestionToTypeConverterTest extends BasicSetup
{
    public function test_question_to_type_converter()
    {
       $answers = [
            SpeakingLanguagesType::getName() => 2,
            ProfessionType::getName() => 'arts_and_entertainment',
            PersonType::getName() => 'risk_taker',
            LearningTimeType::getName() => 'morning',
            FreeTimeType::getName() => '30_minutes',
            MemoryType::getName() => 'short_term',
            ChallengesType::getName() => 'likes_challenges',
            StressfulJobType::getName() => 'stressful_job'
        ];

        $converter = new QuestionToTypeConverter(FrontendTypeList::getList(), new QuestionAnswers($answers));

        $converted = $converter->convert();

        foreach (FrontendTypeList::getList() as $typeName => $typeClass) {
            static::assertArrayHasKey($typeName, $converted);
            static::assertInstanceOf($typeClass, $converted[$typeName]);
        }
    }
}