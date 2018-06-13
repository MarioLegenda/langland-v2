<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\CategoryGateway;
use App\PresentationLayer\Model\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryEntryPoint
{
    /**
     * @var CategoryGateway $categoryGateway
     */
    private $categoryGateway;
    /**
     * CategoryEntryPoint constructor.
     * @param CategoryGateway $categoryGateway
     */
    public function __construct(
        CategoryGateway $categoryGateway
    ) {
        $this->categoryGateway = $categoryGateway;
    }
    /**
     * @param Category $category
     * @return Response
     */
    public function create(Category $category): Response
    {
        $this->categoryGateway->create($category);
    }
}