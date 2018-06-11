<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LogicInterface;

class LanguageLogic implements LogicInterface
{
    /**
     * @param DomainModelInterface|Language $model
     * @return DomainModelInterface
     */
    public function create(DomainModelInterface $model): DomainModelInterface
    {
        $model->handleDates();

        return $model;
    }
}