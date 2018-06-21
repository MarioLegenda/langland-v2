<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Logic\LanguageLogic;
use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Image as DomainImage;
use App\LogicLayer\LearningMetadata\Domain\Language as DomainLanguage;
use App\PresentationLayer\Model\Language as LanguagePresentationModel;

class LanguageGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LogicInterface|LanguageLogic
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
     * @param PresentationModelInterface|LanguagePresentationModel $presentationModel
     * @return LayerPropagationResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResponse
    {
        $this->modelValidator->validate($presentationModel);

        /** @var DomainModelInterface|DomainLanguage $logicModel */
        $logicModel = $this->serializerWrapper
            ->convertFromToByGroup($presentationModel, 'default', Language::class);

        $this->modelValidator->validate($logicModel);

        /** @var DomainImage $domainImage */
        $domainImage = $this->serializerWrapper->convertFromToByGroup(
            $presentationModel->getImage(),
            'default',
            DomainImage::class
        );

        $domainImage->setUploadedFile($presentationModel->getImage()->getUploadedFile());

        $logicModel->setImage($domainImage);
        /** @var LayerPropagationResponse $domainLogicModel */
        $layerPropagationResponse = $this->logic->create($logicModel);

        return $layerPropagationResponse;
    }
}