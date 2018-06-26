<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use Library\Util\Util;

class LanguageCollection implements LayerPropagationCollectionResponse
{
    /**
     * @var bool $isPaginated
     */
    private $isPaginated;
    /**
     * @var iterable $collection
     */
    private $collection;
    /**
     * LanguageCollection constructor.
     * @param iterable|Language|LayerPropagationResourceResponse $languageModels
     * @param bool $isPaginated
     */
    public function __construct(
        iterable $languageModels,
        bool $isPaginated
    ) {
        $this->validateModels($languageModels);
        $this->isPaginated = $isPaginated;
        $this->collection = $languageModels;
    }
    /**
     * @inheritdoc
     */
    public function getPropagationObjects(): iterable
    {
        return $this->collection;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        $collectionGenerator = Util::createGenerator($this->collection);
        $arrayedCollection = [];
        foreach ($collectionGenerator as $entry) {
            /** @var Language $item */
            $item = $entry['item'];

            $arrayedCollection[] = $item->toArray();
        }

        return $arrayedCollection;
    }
    /**
     * @param iterable $languageModels
     * @throws \RuntimeException
     */
    public function validateModels(iterable $languageModels)
    {
        $gen = Util::createGenerator($languageModels);

        foreach ($gen as $entry) {
            $item = $entry['item'];

            if (!$item instanceof LayerPropagationResourceResponse) {
                $message = sprintf(
                    'Invalid model given. Every model in a language collection should be an instance of %s',
                    LayerPropagationResourceResponse::class
                );

                throw new \RuntimeException($message);
            }
        }
    }
}