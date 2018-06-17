<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\Category;
use App\LogicLayer\LearningMetadata\Logic\CategoryLogic;
use App\LogicLayer\LogicInterface;
use App\PresentationLayer\Model\PresentationModelInterface;
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
     * @var LogicInterface $logic
     */
    private $logic;
    /**
     * CategoryGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param LogicInterface|CategoryLogic $logic
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        LogicInterface $logic
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->logic = $logic;
    }
    /**
     * @param PresentationModelInterface $presentationModel
     * @return LayerPropagationResponse
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResponse
    {
        $this->modelValidator->validate($presentationModel);

        /** @var Category $categoryDomainModel */
        $categoryDomainModel = $this->serializerWrapper->convertFromToByGroup($presentationModel, 'default', Category::class);

        $this->modelValidator->validate($categoryDomainModel);

        /** @var LayerPropagationResponse $createdCategoryDomainModel */
        return $this->logic->create($categoryDomainModel);
    }
}