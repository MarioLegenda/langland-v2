<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\Tests\Library\BasicSetup;

class WordEntryPointTest extends BasicSetup
{
    public function test_word_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);

        $wordEntryPoint->create();
    }
}