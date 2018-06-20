<?php

namespace App\Tests\PresentationLayer;

use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\PresentationLayer\Model\Word\Image;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\HttpFoundation\Response;

class WordEntryPointTest extends BasicSetup
{
    public function test_word_create_success()
    {
        /** @var WordEntryPoint $wordEntryPoint */
        $wordEntryPoint = static::$container->get(WordEntryPoint::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        /** @var Language $language */
        $language = $this->createLanguage();
        /** @var CollectionEntity $categories */
        $categories = $this->createCategoryEntityCollection();
        /** @var Image $image */
        $image = $presentationLayerDataProvider->getImageModel();

        $wordPresentationModel = $presentationLayerDataProvider->getCreateWordModel(
            $language,
            $categories,
            $image
        );

        $response = $wordEntryPoint->create($wordPresentationModel);

        static::assertInstanceOf(Response::class, $response);

        $responseData = json_decode($response->getContent(), true);

        static::assertNotEmpty($responseData['resource']['data']);

        $data = $responseData['resource']['data'];

        static::assertInternalType('array', $data['translations']);
        static::assertNotEmpty($data['translations']);

        static::assertInternalType('array', $data['wordCategories']);
        static::assertNotEmpty($data['wordCategories']);
    }
    /**
     * @return Language
     */
    private function createLanguage(): Language
    {
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);
        /** @var Language $languageModel */
        $languageModel = $presentationLayerDataProvider->getLanguageModel();

        /** @var LanguageEntryPoint $languageEntryPoint */
        $languageEntryPoint = $this->locator->get(LanguageEntryPoint::class);

        $data = json_decode($languageEntryPoint->create($languageModel)->getContent(), true);

        /** @var Language $newLanguage */
        $newLanguage = $serializerWrapper->deserialize($data['resource']['data'], Language::class);

        return $newLanguage;
    }
    /**
     * @return CollectionEntity
     */
    private function createCategoryEntityCollection(): CollectionEntity
    {
        /** @var SerializerWrapper $serializerWrapper */
        $serializerWrapper = static::$container->get(SerializerWrapper::class);
        /** @var PresentationModelDataProvider $presentationLayerDataProvider */
        $presentationLayerDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);

        $categories = new CollectionEntity();
        for ($i = 0; $i < 5; $i++) {
            /** @var Category $categoryModel */
            $categoryModel = $presentationLayerDataProvider->getCategoryModel();

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
}