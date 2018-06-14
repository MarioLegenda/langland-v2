<?php

namespace App\LogicGateway\Gateway;

use App\LogicLayer\LearningMetadata\Domain\Category;
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
     * @param LogicInterface|Category $logic
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
     */
    public function create(PresentationModelInterface $presentationModel)
    {
        $this->modelValidator->validate($presentationModel);

        /** @var Category $categoryDomainModel */
        $categoryDomainModel = $this->serializerWrapper->convertFromToByGroup($presentationModel, 'default', Category::class);

        $this->modelValidator->validate($categoryDomainModel);

        $this->logic->create($categoryDomainModel);
    }
}