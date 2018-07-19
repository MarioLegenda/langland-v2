<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationResourceResponse;

class LocaleCollection extends BaseCollectionModel
{
    /**
     * @var bool $isPaginated
     */
    private $isPaginated;
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
     * @return bool
     */
    public function isPaginated(): bool
    {
        return $this->isPaginated;
    }
}