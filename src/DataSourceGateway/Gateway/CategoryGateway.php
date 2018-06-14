<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
use App\DataSourceLayer\LearningMetadata\Category;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class CategoryGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var Category $category
     */
    private $category;
    /**
     * CategoryGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param Category $category
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        Category $category
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->category = $category;
    }
    /**
     * @param DomainModelInterface $domainModel
     */
    public function create(DomainModelInterface $domainModel)
    {
        $this->modelValidator->validate($domainModel);

        /** @var CategoryDataSource $categoryDataSource */
        $categoryDataSource = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', CategoryDataSource::class);

        $this->modelValidator->validate($categoryDataSource);

        $this->category->createIfNotExists($categoryDataSource);
    }
}