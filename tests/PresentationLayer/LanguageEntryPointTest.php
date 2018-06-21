<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Util\ApiResponseData;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;

class LanguageEntryPointTest extends BasicSetup
{
    public function test_language_create()
    {
        $languageRepository = $this->locator->get(LanguageRepository::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getLanguageModel(
            $presentationModelDataProvider->getImageModel()
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'PUT');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertNotEmpty($apiResponseData->getData()['data']);

        $data = $apiResponseData->getData()['data'];

        static::assertInternalType('array', $data['image']);
        static::assertNotEmpty($data['image']);

        $createdLanguage = $languageRepository->findOneBy([
            'name' => $data['name'],
        ]);

        static::assertInstanceOf(LanguageDataSource::class, $createdLanguage);
    }

    public function test_existing_language_fail()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getLanguageModel(
            $presentationModelDataProvider->getImageModel()
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'PUT');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertNotEmpty($apiResponseData->getData()['data']);

        $existingLanguageException = false;

        try {
            $languageEntryPoint->create($languageModel);
        } catch (\RuntimeException $e) {
            $existingLanguageException = true;
        }

        static::assertTrue($existingLanguageException);
    }

    public function test_fail_language_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var ModelValidator $deserializer */
        $modelValidator = $this->locator->get(ModelValidator::class);

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getInvalidLanguageModel();

        $enteredException = false;
        try {
            $modelValidator->validate($languageModel);
        } catch (\RuntimeException $e) {
            $enteredException = true;
        }

        static::assertTrue($enteredException);
    }
}