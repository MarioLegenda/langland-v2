<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\DataSourceEntity;
use App\DataSourceLayer\RepositoryFactory;
use App\DataSourceLayer\Type\MysqlType;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Util\ApiResponseData;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Doctrine\Entity\Language as LanguageDataSource;

class LanguageEntryPointTest extends BasicSetup
{
    public function test_language_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var ModelValidator $deserializer */
        $modelValidator = $this->locator->get(ModelValidator::class);

        /** @var Language $languageModel */
        $languageModel = $presentationModelDataProvider->getLanguageModel();

        $modelValidator->validate($languageModel);

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        /** @var Response $response */
        $response = $languageEntryPoint->create($languageModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'GET');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertEmpty($apiResponseData->getData()['data']);

        /** @var LanguageDataSource|DataSourceEntity $languageDataSource */
        $languageDataSource = RepositoryFactory::create(LanguageDataSource::class, MysqlType::fromValue())->findOneBy([
            'name' => $languageModel->getName(),
        ]);

        static::assertInstanceOf(LanguageDataSource::class, $languageDataSource);
        static::assertEquals($languageModel->getName(), $languageDataSource->getName());
    }

    public function test_fail_language_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var ModelValidator $deserializer */
        $modelValidator = $this->locator->get(ModelValidator::class);

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