<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
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
     * @return DataSourceEntity|CategoryDataSource
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DataSourceEntity
    {
        $this->modelValidator->validate($domainModel);

        /** @var CategoryDataSource $categoryDataSource */
        $categoryDataSource = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', CategoryDataSource::class);

        return $this->categoryDataSourceService->createIfNotExists($categoryDataSource);
    }
}