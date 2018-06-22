<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\Model\Category;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Util\ApiResponseData;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;

class CategoryEntryPointTest extends BasicSetup
{
    public function test_category_create_success()
    {
        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = static::$container->get(CategoryRepository::class);
        /** @var CategoryEntryPoint $categoryEntryPoint */
        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel();

        /** @var Response $response */
        $response = $categoryEntryPoint->create($categoryModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertTrue(Util::isValidDate($data['createdAt']));
        static::assertNull($data['updatedAt']);

        $createdCategory = $categoryRepository->findOneBy([
            'name' => $data['name'],
        ]);

        static::assertInstanceOf(CategoryDataSource::class, $createdCategory);
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

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertTrue(Util::isValidDate($data['createdAt']));
        static::assertNull($data['updatedAt']);

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

        /** @var Category $categoryModel */
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