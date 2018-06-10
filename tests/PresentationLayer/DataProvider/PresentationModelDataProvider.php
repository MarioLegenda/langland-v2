<?php

namespace App\Tests\PresentationLayer\DataProvider;

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

}