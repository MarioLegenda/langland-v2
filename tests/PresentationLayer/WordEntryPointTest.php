<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Infrastructure\Helper\TypedArray;

class WordEntryPointTest extends BasicSetup
{
    public function test_word_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $createdLanguageModel = $this->createLanguage();
        $categories = $this->createCategories();

        $wordPresentationModel = $presentationModelDataProvider->getWordModel(
            $createdLanguageModel,
            $categories,
            $presentationModelDataProvider->getImageModel()
        );

        $wordEntryPoint->create($wordPresentationModel);
    }
    /**
     * @return Language
     */
    public function createLanguage(): Language
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var Language $languagePresentationModel */
        $languagePresentationModel = $presentationModelDataProvider->getLanguageModel();
        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = static::$container->get(LanguageEntryPoint::class);
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);

        $response = $languageEntryPoint->create($languagePresentationModel);

        /** @var Language $createdLanguageModel */
        $createdLanguageModel = $serializerWrapper->deserialize(
            json_decode($response->getContent(), true)['resource']['data'],
            Language::class
        );

        return $createdLanguageModel;
    }
    /**
     * @return iterable|TypedArray|Category[]
     */
    public function createCategories(): iterable
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var CategoryEntryPoint $categoryEntryPoint */
        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);

        $categories = TypedArray::create('integer', Category::class);

        for ($i = 0; $i < 5; $i++) {
            /** @var Category $categoryPresentationModel */
            $categoryPresentationModel = $presentationModelDataProvider->getCategoryModel();

            $response = $categoryEntryPoint->create($categoryPresentationModel);

            /** @var Category $createdLanguageModel */
            $createdCategoryModel = $serializerWrapper->deserialize(
                json_decode($response->getContent(), true)['resource']['data'],
                Category::class
            );

            $categories[] = $createdCategoryModel;
        }

        return $categories;
    }
}