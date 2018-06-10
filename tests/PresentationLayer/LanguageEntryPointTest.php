<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\Language;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LanguageEntryPointTest extends WebTestCase
{
    public function test_language_create()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $container->get(PresentationModelDataProvider::class);

        $languageModel = $presentationModelDataProvider->getLanguageModel();

        /** @var Language $languageEntryPoint */
        $languageEntryPoint = $container->get(Language::class);

        $languageEntryPoint->create($languageModel);
    }
}