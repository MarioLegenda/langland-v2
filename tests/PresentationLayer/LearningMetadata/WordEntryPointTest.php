<?php

namespace App\Tests\PresentationLayer\LearningMetadata;

use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\Infrastructure\Model\Lesson;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\PresentationLayer\Infrastructure\Model\Category;
use App\PresentationLayer\Infrastructure\Model\Language;
use App\PresentationLayer\Infrastructure\Model\Locale;
use App\PresentationLayer\Infrastructure\Model\Word\Translation;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Infrastructure\Helper\TypedArray;
use Library\Util\Util;
use Symfony\Component\HttpFoundation\Response;
use App\PresentationLayer\Infrastructure\Model\Image;

class WordEntryPointTest extends BasicSetup
{
    public function test_word_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();
        /** @var Language $language */
        $language = $this->createLanguage($localeModel);
        /** @var CollectionEntity $categories */
        $categories = $this->createCategoryEntityCollection($localeModel);
        /** @var Image $image */
        $image = $presentationLayerDataProvider->getImageModel();

        $translations = TypedArray::create('integer', Translation::class);
        for ($i = 0; $i < 5; $i++) {
            $translations[] = $presentationLayerDataProvider->getTranslationModel($localeModel);
        }

        $wordPresentationModel = $presentationLayerDataProvider->getCreateWordModel(
            $language,
            $categories,
            $image,
            $translations
        );

        $response = $wordEntryPoint->create($wordPresentationModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        static::assertInstanceOf(Response::class, $response);

        $responseData = json_decode($response->getContent(), true);

        static::assertNotEmpty($responseData['resource']['data']);

        $data = $responseData['resource']['data'];

        $this->assertResponse($data);
    }

    public function test_word_with_lesson_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var LessonEntryPoint $lessonEntryPoint */
        $lessonEntryPoint = static::$container->get(LessonEntryPoint::class);

        /** @var Locale $localeModel */
        $localeModel = $this->createLocale();
        /** @var Language $language */
        $language = $this->createLanguage($localeModel);
        /** @var CollectionEntity $categories */
        $categories = $this->createCategoryEntityCollection($localeModel);
        /** @var Image $image */
        $image = $presentationLayerDataProvider->getImageModel();

        $lessonModel = $presentationLayerDataProvider->getLessonModel(
            $language,
            $localeModel
        );

        $lessonEntryPoint->create($lessonModel);

        $translations = TypedArray::create('integer', Translation::class);
        for ($i = 0; $i < 5; $i++) {
            $translations[] = $presentationLayerDataProvider->getTranslationModel($localeModel);
        }

        $wordPresentationModel = $presentationLayerDataProvider->getCreateWordModelWithLesson(
            $lessonModel,
            $language,
            $categories,
            $image,
            $translations
        );

        $response = $wordEntryPoint->create($wordPresentationModel);

        static::assertInstanceOf(Response::class, $response);
        static::assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        $this->assertResponse($responseData);

        $lessonData = $responseData['lesson'];

        static::assertInternalType('int', $lessonData['id']);
        static::assertNotEmpty($lessonData['id']);
        static::assertInternalType('string', $lessonData['name']);
        static::assertNotEmpty($lessonData['name']);
        static::assertInternalType('string', $lessonData['locale']);
        static::assertNotEmpty($lessonData['locale']);
        static::assertInternalType('string', $lessonData['internalName']);
        static::assertNotEmpty($lessonData['internalName']);
        static::assertInternalType('array', $lessonData['lessonData']);
        static::assertNotEmpty($lessonData['lessonData']);

        static::assertTrue(Util::isValidDate($lessonData['createdAt']));
        static::assertNull($lessonData['updatedAt']);
    }
    /**
     * @param array $response
     */
    private function assertResponse(array $response)
    {
        static::assertInternalType('int', $response['id']);

        static::assertNotEmpty($response['name']);
        static::assertInternalType('string', $response['name']);

        static::assertNotEmpty($response['type']);
        static::assertInternalType('string', $response['type']);

        static::assertInternalType('array', $response['language']);
        static::assertNotEmpty($response['language']);

        $language = $response['language'];

        static::assertInternalType('int', $language['id']);
        static::assertInternalType('string', $language['name']);
        static::assertNotEmpty($language['name']);
        static::assertInternalType('string', $language['locale']);
        static::assertNotEmpty($language['locale']);
        static::assertInternalType('string', $language['createdAt']);
        static::assertNotEmpty($language['createdAt']);
        static::assertTrue(Util::isValidDate($language['createdAt']));
        static::assertNull($language['updatedAt']);

        static::assertNotEmpty($response['description']);
        static::assertInternalType('string', $response['description']);

        static::assertInternalType('int', $response['level']);

        static::assertNotEmpty($response['pluralForm']);
        static::assertInternalType('string', $response['pluralForm']);

        static::assertInternalType('array', $response['translations']);
        static::assertNotEmpty($response['translations']);

        foreach ($response['translations'] as $translation) {
            static::assertInternalType('int', $translation['id']);

            static::assertNotEmpty($translation['name']);
            static::assertInternalType('string', $translation['name']);

            static::assertInternalType('bool', $translation['valid']);

            static::assertInternalType('string', $translation['locale']);
            static::assertNotEmpty($translation['locale']);

            static::assertInternalType('string', $translation['createdAt']);
            static::assertTrue(Util::isValidDate($translation['createdAt']));
            static::assertNull($translation['updatedAt']);
        }

        static::assertInternalType('array', $response['wordCategories']);
        static::assertNotEmpty($response['wordCategories']);

        foreach ($response['wordCategories'] as $wordCategory) {
            static::assertInternalType('int', $wordCategory);
        }

        static::assertInternalType('array', $response['image']);
        static::assertNotEmpty($response['image']);

        $image = $response['image'];

        static::assertInternalType('int', $image['id']);
        static::assertInternalType('string', $image['name']);
        static::assertNotEmpty($image['name']);
        static::assertInternalType('string', $image['relativePath']);
        static::assertNotEmpty($image['relativePath']);
        static::assertInternalType('string', $image['createdAt']);
        static::assertTrue(Util::isValidDate($image['createdAt']));
        static::assertNull($image['updatedAt']);
    }
    /**
     * @param Locale $locale
     * @return Language
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguage(Locale $locale = null): Language
    {
        if (!$locale instanceof Locale) {
            $locale = $this->createLocale();
        }

        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var Language $languageModel */
        $languageModel = $presentationLayerDataProvider->getLanguageModel(
            $presentationLayerDataProvider->getImageModel(),
            $locale
        );

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        $data = json_decode($languageEntryPoint->create($languageModel)->getContent(), true);

        /** @var Language $newLanguage */
        $newLanguage = $serializerWrapper->deserialize($data['resource']['data'], Language::class);

        return $newLanguage;
    }
    /**
     * @param Locale $locale
     * @return CollectionEntity
     */
    private function createCategoryEntityCollection(
        Locale $locale
    ): CollectionEntity {
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);

        $categories = new CollectionEntity();
        for ($i = 0; $i < 5; $i++) {
            /** @var Category $categoryModel */
            $categoryModel = $presentationLayerDataProvider->getCategoryModel($locale);

            $data = json_decode($categoryEntryPoint->create($categoryModel)->getContent(), true);

            /** @var Category $category */
            $category = $serializerWrapper->deserialize($data['resource']['data'], Category::class);

            $categoryMetadata = new CollectionMetadata(
                $category->getId(),
                ActionType::fromValue('create')
            );

            $categories->addMetadata($categoryMetadata);
        }
        return $categories;
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