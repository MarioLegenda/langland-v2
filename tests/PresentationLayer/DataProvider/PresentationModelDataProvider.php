<?php

namespace App\Tests\PresentationLayer\DataProvider;

use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\Tests\Library\FakerTrait;
use Library\Infrastructure\Helper\Deserializer;

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
            'name' => 'category',
        ];

        /** @var Category $category */
        $category = $this->deserializer->create($modelBlueprint, Category::class);

        return $category;
    }

}