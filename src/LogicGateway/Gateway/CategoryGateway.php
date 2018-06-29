<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\Category;
use App\LogicLayer\LearningMetadata\Logic\CategoryLogic;
use App\LogicLayer\LogicInterface;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\PresentationLayer\Infrastructure\Model\Category as CategoryPresentationModel;

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
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResourceResponse
    {
        $this->modelValidator->validate($presentationModel);

        /** @var Category $categoryDomainModel */
        $categoryDomainModel = $this->serializerWrapper->convertFromToByGroup($presentationModel, 'default', Category::class);

        $this->modelValidator->validate($categoryDomainModel);

        /** @var LayerPropagationResourceResponse $propagationResponse */
        $propagationResponse = $this->logic->create($categoryDomainModel);

        return $propagationResponse;
    }
}