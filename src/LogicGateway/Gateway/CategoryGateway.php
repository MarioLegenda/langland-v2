<?php

namespace App\LogicGateway\Gateway;

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
     * @var LogicInterface|CategoryLogic
     */
    private $logic;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * LanguageGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LogicInterface $logic
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LogicInterface $logic,
        ModelValidator $modelValidator
    ) {
        $this->logic = $logic;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
    }
    /**
     * @param PresentationModelInterface $presentationModel
     */
    public function create(PresentationModelInterface $presentationModel)
    {
        /** @var Category $logicModel */
        $logicModel = $this->serializerWrapper->convertFromToByGroup($presentationModel, 'default', Category::class);

        $this->modelValidator->validate($logicModel);

        $this->logic->create($logicModel);
    }
}