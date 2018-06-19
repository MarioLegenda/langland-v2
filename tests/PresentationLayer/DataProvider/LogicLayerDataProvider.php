<?php

namespace App\Tests\PresentationLayer\DataProvider;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
use App\Tests\Library\FakerTrait;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Category as CategoryDomainModel;

class LogicLayerDataProvider
{
    use FakerTrait;

    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * LogicLayerDataProvider constructor.
     * @param SerializerWrapper $serializerWrapper
     */
    public function __construct(
        SerializerWrapper $serializerWrapper
    ) {
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @return CategoryDomainModel
     */
    public function createCategory(): CategoryDomainModel
    {
        $modelBlueprint = [
            'name' => $this->faker()->name,
        ];

        /** @var CategoryDomainModel $categoryDomainModel */
        $categoryDomainModel = $this->serializerWrapper->deserialize($modelBlueprint, CategoryDomainModel::class);

        return $categoryDomainModel;
    }
}