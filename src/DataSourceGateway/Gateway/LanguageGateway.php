<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\RepositoryFactory;
use App\DataSourceLayer\Type\MysqlType;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;

class LanguageGateway
{
    public function create(DomainModelInterface $model)
    {
        /** @var LanguageRepository $repository */
        $repository = RepositoryFactory::create(get_class($model), MysqlType::fromValue());

        // todo: conversion to a data source model goes here along with any validation

        $repository->save($model);
    }
}