<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Util\ApiResponseData;
use Symfony\Component\HttpFoundation\Response;

class LanguageEntryPointTest extends BasicSetup
{
    public function test_language_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        $languageModel = $presentationModelDataProvider->getLanguageModel();

        /** @var Language $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(Language::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'GET');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertEmpty($apiResponseData->getData()['data']);
    }
}