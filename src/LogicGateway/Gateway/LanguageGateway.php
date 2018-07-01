<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\Library\Http\Request\Contract\PaginatedRequestInterface;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LearningMetadata\Model\LanguageCollection;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Logic\LanguageLogic;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Image as DomainImage;
use App\LogicLayer\LearningMetadata\Domain\Language as DomainLanguage;
use App\PresentationLayer\Infrastructure\Model\Language as LanguagePresentationModel;

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
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResourceResponse
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

        $this->modelValidator->validate($logicModel);

        /** @var LayerPropagationResourceResponse $domainLogicModel */
        $layerPropagationResponse = $this->logic->create($logicModel);

        return $layerPropagationResponse;
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return LayerPropagationCollectionResponse
     */
    public function getLanguages(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): LayerPropagationCollectionResponse
    {
        /** @var LanguageCollection $languages */
        $languages = $this->logic->getLanguages($paginatedInternalizedRequest);

        return $languages;
    }
}