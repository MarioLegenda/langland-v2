<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\CategoryGateway;
use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\Category;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LogicInterface;
use App\PresentationLayer\Model\PresentationModelInterface;

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
     * @return LayerPropagationResponse
     */
    public function create(DomainModelInterface $domainModel): LayerPropagationResponse
    {
        $domainModel->handleDates();

        return $this->categoryGateway->create($domainModel);
    }
}