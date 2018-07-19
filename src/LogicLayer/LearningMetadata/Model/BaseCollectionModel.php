<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use Library\Util\Util;

class BaseCollectionModel implements LayerPropagationCollectionResponse
{
    /**
     * @var iterable $collection
     */
    protected $collection;
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
    /**
     * @return iterable
     */
    public function getPropagationObjects(): iterable
    {
        $message = sprintf(
            'Parent implementation of BaseCollectionModel::getPropagationObjects() cannot be used. Implement the method in a class that extends \'%s\'',
            BaseCollectionModel::class
        );

        throw new \RuntimeException($message);
    }
}