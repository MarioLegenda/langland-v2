<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\Language;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LanguageEntryPointTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        static::createClient();
    }

    public function test_language_create()
    {
        /** @var LanguageEntryPointTest $presentationModelDataProvider */
        $languageEntryPoint = static::$container
            ->get(Language::class);

        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $languageModel = $presentationModelDataProvider->getLanguageModel();


    }
}