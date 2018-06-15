<?php

namespace App\Tests\PresentationLayer\DataProvider;

use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\PresentationLayer\Model\Word\Word;
use App\Tests\Library\FakerTrait;
use Library\Infrastructure\Helper\Deserializer;
use Library\Infrastructure\Helper\TypedArray;

class PresentationModelDataProvider
{
    use FakerTrait;
    /**
     * @var Deserializer $deserializer
     */
    private $deserializer;
    /**
     * PresentationModelDataProvider constructor.
     * @param Deserializer $deserializer
     */
    public function __construct(
        Deserializer $deserializer
    ) {
        $this->deserializer = $deserializer;
    }
    /**
     * @return Language
     */
    public function getLanguageModel(): Language
    {
        $modelBlueprint = [
            'name' => $this->faker()->name,
            'showOnPage' => false,
            'description' => $this->faker()->sentence(30),
            'images' => [
                'image1',
                'image2',
            ],
        ];

        /** @var Language $language */
        $language = $this->deserializer->create($modelBlueprint, Language::class);

        return $language;
    }
    /**
     * @return Language
     */
    public function getInvalidLanguageModel(): Language
    {
        $modelBlueprint = [
            'name' => '',
            'showOnPage' => 'čsdfjlksadjf',
            'description' => $this->faker()->sentence(30),
            'images' => [],
        ];

        /** @var Language $language */
        $language = $this->deserializer->create($modelBlueprint, Language::class);

        return $language;
    }
    /**
     * @return Category
     */
    public function getCategoryModel(): Category
    {
        $modelBlueprint = [
            'name' => $this->faker()->name,
        ];

        /** @var Category $category */
        $category = $this->deserializer->create($modelBlueprint, Category::class);

        return $category;
    }
    /**
     * @return Category
     */
    public function getInvalidCategoryModel(): Category
    {
        $modelBlueprint = [
            'name' => null,
        ];

        /** @var Category $category */
        $category = $this->deserializer->create($modelBlueprint, Category::class);

        return $category;
    }
    /**
     * @param int $languageId
     * @param int|null $level
     * @param TypedArray $categories
     * @return Word
     */
    public function getWordModel(
        int $languageId,
        TypedArray $categories,
        int $level = null
    ): Word {
        $modelBlueprint = [
            'name' => $this->faker()->name,
            'type' => $this->faker()->name,
            'language' => $languageId,
            'description' => $this->faker()->sentence(20),
            'level' => (is_null($level)) ? rand(1, 5) : $level,
            'pluralForm' => $this->faker()->name,
            'categories' => $categories->toArray(),
        ];
    }

}