<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\CategoryGateway;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\Category;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Model\Category as CategoryModel;

class CategoryLogic implements LogicInterface
{
    /**
     * @var CategoryGateway $categoryGateway
     */
    private $categoryGateway;
    /**
     * CategoryLogic constructor.
     * @param CategoryGateway $categoryGateway
     */
    public function __construct(
        CategoryGateway $categoryGateway
    ) {
        $this->categoryGateway = $categoryGateway;
    }
    /**
     * @param DomainModelInterface|Category $domainModel
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): LayerPropagationResourceResponse
    {
        $newCategory = $this->categoryGateway->create($domainModel);

        return new CategoryModel($newCategory);
    }
}