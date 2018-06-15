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
     * @return DomainModelInterface|Language
     */
    public function create(DomainModelInterface $model): DomainModelInterface
    {
        $model->handleDates();

        return $this->languageGateway->create($model);
    }
}