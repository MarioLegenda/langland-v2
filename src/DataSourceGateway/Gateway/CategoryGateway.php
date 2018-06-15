<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
use App\LogicLayer\LearningMetadata\Domain\Category as CategoryDomainModel;
use App\DataSourceLayer\LearningMetadata\CategoryDataSourceService;
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
     * @var CategoryDataSource $categoryDataSourceService
     */
    private $categoryDataSourceService;
    /**
     * CategoryGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param CategoryDataSourceService $categoryDataSourceService
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        CategoryDataSourceService $categoryDataSourceService
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->categoryDataSourceService = $categoryDataSourceService;
    }
    /**
     * @param DomainModelInterface $domainModel
     * @return DomainModelInterface
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        $this->modelValidator->validate($domainModel);

        /** @var CategoryDataSource $categoryDataSource */
        $categoryDataSource = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', CategoryDataSource::class);

        $this->modelValidator->validate($categoryDataSource);

        $newCategory = $this->categoryDataSourceService->createIfNotExists($categoryDataSource);

        /** @var DomainModelInterface|CategoryDomainModel $domainModelCategory */
        $domainModelCategory = $this->serializerWrapper
            ->convertFromToByGroup($newCategory, 'default', CategoryDomainModel::class);

        return $domainModelCategory;
    }
}