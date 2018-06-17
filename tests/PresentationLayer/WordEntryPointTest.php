<?php

namespace App\Tests\PresentationLayer;

use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\Helper\SerializerWrapper;

class WordEntryPointTest extends BasicSetup
{
    public function test_word_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $createdLanguageModel = $this->createLanguage();
        $categories = $this->getCreateCategoryMetadata();

        $wordPresentationModel = $presentationModelDataProvider->getCreateWordModel(
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
     * @return CollectionEntity
     */
    public function getCreateCategoryMetadata(): CollectionEntity
    {
        /** @var PresentationModelDataProvider $presentationModelDataProvider */
        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var CategoryEntryPoint $categoryEntryPoint */
        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);

        $categories = new CollectionEntity();

        for ($i = 0; $i < 5; $i++) {
            /** @var Category $categoryPresentationModel */
            $categoryPresentationModel = $presentationModelDataProvider->getCategoryModel();

            $response = $categoryEntryPoint->create($categoryPresentationModel);
            $data = json_decode($response->getContent(), true)['resource']['data'];

            /** @var Category $createdLanguageModel */
            $createdCategoryModel = $serializerWrapper->deserialize(
                $data,
                Category::class
            );

            $categoryMetadata = new CollectionMetadata(
                $createdCategoryModel->getId(),
                ActionType::fromValue('create')
            );

            $categories->addMetadata($categoryMetadata);
        }

        return $categories;
    }
}