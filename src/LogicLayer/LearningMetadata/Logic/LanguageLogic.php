<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\LanguageGateway;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LogicInterface;

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
     */
    public function create(DomainModelInterface $model)
    {
        $model->handleDates();

        $this->languageGateway->create($model);
    }
}