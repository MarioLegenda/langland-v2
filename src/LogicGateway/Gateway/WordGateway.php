<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Word\Word as WordDomainModel;
use App\LogicLayer\LearningMetadata\Logic\WordLogic;
use App\LogicLayer\LogicInterface;
use App\PresentationLayer\Model\PresentationModelInterface;
use App\PresentationLayer\Model\Word\Word;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Image;

class WordGateway
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
     * @var WordLogic|LogicInterface $wordLogic
     */
    private $wordLogic;
    /**
     * WordGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param LogicInterface|WordLogic $logic
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        LogicInterface $logic
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->wordLogic = $logic;
    }
    /**
     * @param PresentationModelInterface|Word $presentationModel
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResourceResponse
    {
        $this->modelValidator->validate($presentationModel);

        $categories = $presentationModel->getCategories();

        /** @var WordDomainModel|DomainModelInterface $wordDomainModel */
        $wordDomainModel = $this->serializerWrapper->convertFromToByGroup(
            $presentationModel,
            'default',
            WordDomainModel::class
        );

        /** @var Image $domainImage */
        $domainImage = $this->serializerWrapper->convertFromToByGroup(
            $presentationModel->getImage(),
            'default',
            Image::class
        );

        $domainImage->setUploadedFile($presentationModel->getImage()->getUploadedFile());
        $wordDomainModel->setImage($domainImage);
        $wordDomainModel->setCategories($categories);

        return $this->wordLogic->create($wordDomainModel);
    }
}