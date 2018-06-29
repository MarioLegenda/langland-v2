<?php

namespace App\Tests\PresentationLayer;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\CategoryRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Locale;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Category as CategoryDataSource;

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
        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();

        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel($localeModel);

        /** @var Response $response */
        $response = $categoryEntryPoint->create($categoryModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertInternalType('string', $data['locale']);
        static::assertNotEmpty($data['locale']);
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
        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();
        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel($localeModel);

        /** @var Response $response */
        $response = $categoryEntryPoint->create($categoryModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        static::assertInternalType('int', $data['id']);
        static::assertNotEmpty($data['name']);
        static::assertInternalType('string', $data['locale']);
        static::assertNotEmpty($data['locale']);
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
    /**
     * @param string $name
     * @return Locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLocale(string $name = 'en'): Locale
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = $this->locator->get(PresentationModelDataProvider::class);

        /** @var LocaleEntryPoint $localeEntryPoint */
        $localeEntryPoint = $this->locator->get(LocaleEntryPoint::class);
        /** @var Locale $localeModel */
        $localeModel = $presentationModelDataProvider->getLocaleModel([
            'name' => $name,
            'default' => true,
        ]);

        $response = $localeEntryPoint->create($localeModel);

        $data = json_decode($response->getContent(), true)['resource']['data'];

        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = $this->locator->get(SerializerWrapper::class);
        /** @var Locale $localeModel */
        $localeModel = $serializerWrapper->deserialize($data, Locale::class);

        return $localeModel;
    }
}