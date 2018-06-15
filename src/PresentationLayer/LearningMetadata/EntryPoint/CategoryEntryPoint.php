<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\CategoryGateway;
use App\PresentationLayer\Model\Category as CategoryModel;
use App\PresentationLayer\Model\PresentationModelInterface;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class CategoryEntryPoint
{
    /**
     * @var CategoryGateway $categoryGateway
     */
    private $categoryGateway;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * CategoryEntryPoint constructor.
     * @param CategoryGateway $categoryGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        CategoryGateway $categoryGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->categoryGateway = $categoryGateway;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param CategoryModel $category
     * @return Response
     */
    public function create(CategoryModel $category): Response
    {
        /** @var PresentationModelInterface|CategoryModel $createdCategory */
        $createdCategory = $this->categoryGateway->create($category);

        return $this->apiResponseWrapper->createCategoryCreate($createdCategory->toArray());
    }
}