<?php

namespace App\LogicGateway\Gateway;

use App\LogicLayer\LearningMetadata\Domain\Category;
use App\PresentationLayer\Model\Category as PresentationModelCategory;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
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
     * @return PresentationModelInterface|PresentationModelCategory
     */
    public function create(PresentationModelInterface $presentationModel): PresentationModelInterface
    {
        $this->modelValidator->validate($presentationModel);

        /** @var Category $categoryDomainModel */
        $categoryDomainModel = $this->serializerWrapper->convertFromToByGroup($presentationModel, 'default', Category::class);

        $this->modelValidator->validate($categoryDomainModel);

        /** @var DomainModelInterface|Category $createdCategoryDomainModel */
        $createdCategoryDomainModel = $this->logic->create($categoryDomainModel);

        /** @var PresentationModelInterface|PresentationModelCategory $createdPresentationCategory */
        $createdPresentationCategory = $this->serializerWrapper
            ->convertFromToByGroup($createdCategoryDomainModel, 'default', PresentationModelCategory::class);

        return $createdPresentationCategory;
    }
}