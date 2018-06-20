<?php

namespace App\Tests\PresentationLayer\DataProvider;

use App\Infrastructure\Model\CollectionEntity;
use App\PresentationLayer\Model\Category;
use App\PresentationLayer\Model\Language;
use App\PresentationLayer\Model\Word\Translation;
use App\PresentationLayer\Model\Word\Word;
use App\Tests\Library\FakerTrait;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;
use Library\Infrastructure\Helper\Deserializer;
use Library\Infrastructure\Helper\TypedArray;
use App\PresentationLayer\Model\Image;

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
     * @param Language $language
     * @param CollectionEntity $categories
     * @param Image $image
     * @param TypedArray|null $translations
     * @param int|null $level
     * @return Word
     */
    public function getCreateWordModel(
        Language $language,
        CollectionEntity $categories,
        Image $image,
        TypedArray $translations = null,
        int $level = null
    ): Word {
        if (!$translations instanceof TypedArray) {
            $translations = TypedArray::create('integer', Translation::class);
            for ($i = 0; $i < 5; $i++) {
                $translations[] = $this->getTranslationModel();
            }
        }

        $modelBlueprint = [
            'name' => $this->faker()->name,
            'type' => $this->faker()->name,
            'language' => $language->toArray(),
            'description' => $this->faker()->sentence(20),
            'level' => (is_null($level)) ? rand(1, 5) : $level,
            'pluralForm' => $this->faker()->name,
            'translations' => $translations->toArray(),
        ];

        /** @var Word $word */
        $word = $this->deserializer->create($modelBlueprint, Word::class);
        $word->setImage($image);
        $word->setCategories($categories);

        return $word;
    }
    /**
     * @return Translation
     */
    public function getTranslationModel(): Translation
    {
        $modelBlueprint = [
            'name' => $this->faker()->name,
            'valid' => (bool) rand(0, 1),
        ];

        /** @var Translation $translation */
        $translation = $this->deserializer->create($modelBlueprint, Translation::class);

        return $translation;
    }
    /**
     * @return Image
     */
    public function getImageModel(): Image
    {
        //$file = $this->faker()->image();

        return new Image(new UploadedFile('sdfjkasdhfj'));
    }

}