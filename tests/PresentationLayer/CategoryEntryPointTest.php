<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\Model\Category;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Util\ApiResponseData;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;

class CategoryEntryPointTest extends BasicSetup
{
    public function test_category_create_success()
    {
        /** @var CategoryEntryPoint $categoryEntryPoint */
        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel();

        /** @var Response $response */
        $response = $categoryEntryPoint->create($categoryModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'PUT');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertEmpty($apiResponseData->getData()['data']);

        /** @var RepositoryFactory $repositoryFactory */
        $repositoryFactory = static::$container->get(RepositoryFactory::class);

        /** @var CategoryDataSource|DataSourceEntity $categoryDataSource */
        $categoryDataSource = $repositoryFactory->create(CategoryDataSource::class, MysqlType::fromValue())->findOneBy([
            'name' => $categoryModel->getName(),
        ]);

        static::assertInstanceOf(CategoryDataSource::class, $categoryDataSource);
        static::assertEquals($categoryModel->getName(), $categoryDataSource->getName());
    }

    public function test_existing_category_fail()
    {
        /** @var CategoryEntryPoint $categoryEntryPoint */
        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel();

        /** @var Response $response */
        $response = $categoryEntryPoint->create($categoryModel);

        $data = json_decode($response->getContent(), true);

        $apiResponseData = new ApiResponseData($data);

        static::assertEquals($apiResponseData->getMethod(), 'PUT');
        static::assertEquals($apiResponseData->getStatusCode(), 201);
        static::assertTrue($apiResponseData->isResource());
        static::assertFalse($apiResponseData->isCollection());
        static::assertEmpty($apiResponseData->getData()['data']);

        /** @var RepositoryFactory $repositoryFactory */
        $repositoryFactory = static::$container->get(RepositoryFactory::class);

        /** @var CategoryDataSource|DataSourceEntity $categoryDataSource */
        $categoryDataSource = $repositoryFactory->create(CategoryDataSource::class, MysqlType::fromValue())->findOneBy([
            'name' => $categoryModel->getName(),
        ]);

        static::assertInstanceOf(CategoryDataSource::class, $categoryDataSource);
        static::assertEquals($categoryModel->getName(), $categoryDataSource->getName());

        $existingCategoryException = false;
        try {
            $categoryEntryPoint->create($categoryModel);
        } catch (\RuntimeException $e) {
            $existingCategoryException = true;
        }

        static::assertTrue($existingCategoryException);
    }

    public function test_fail_category_create()
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);
        /** @var ModelValidator $deserializer */
        $modelValidator = $this->locator->get(ModelValidator::class);

        $categoryModel = $presentationModelDataProvider->getInvalidCategoryModel();

        $enteredException = false;
        try {
            $modelValidator->validate($categoryModel);
        } catch (\RuntimeException $e) {
            $enteredException = true;
        }

        static::assertTrue($enteredException);
    }
}