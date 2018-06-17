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
use App\PresentationLayer\Model\Language as PresentationModelLanguage;

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
     * @param PresentationModelInterface $model
     * @return LayerPropagationResponse
     */
    public function create(PresentationModelInterface $model): LayerPropagationResponse
    {
        $this->modelValidator->validate($model);

        /** @var DomainModelInterface $logicModel */
        $logicModel = $this->serializerWrapper
            ->convertFromToByGroup($model, 'default', Language::class);

        $this->modelValidator->validate($logicModel);

        /** @var DomainModelInterface $domainLogicModel */
        $languageDomainModel = $this->logic->create($logicModel);

        /** @var PresentationModelInterface|PresentationModelLanguage $presentationModelLanguage */
        $presentationModelLanguage = $this->serializerWrapper
            ->convertFromToByGroup($languageDomainModel, 'default', PresentationModelLanguage::class);

        return $presentationModelLanguage;
    }
}