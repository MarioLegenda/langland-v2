<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\LanguageGateway;
use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Model\Language as LanguageResponseModel;

class LanguageLogic implements LogicInterface
{
    /**
     * @var LanguageGateway $languageGateway
     */
    private $languageGateway;

    public function __construct(
        LanguageGateway $languageGateway
    ) {
        $this->languageGateway = $languageGateway;
    }
    /**
     * @param DomainModelInterface|Language $model
     * @return LayerPropagationResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $model): LayerPropagationResponse
    {
        $model->handleDates();

        /** @var DataSourceEntity $newLanguage */
        $newLanguage = $this->languageGateway->create($model);

        return new LanguageResponseModel($newLanguage);
    }
}