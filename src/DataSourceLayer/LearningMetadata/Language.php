<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;

class Language
{
    /**
     * @param DataSourceEntity|LanguageDataSource $language
     */
    public function create(DataSourceEntity $language)
    {
        RepositoryFactory::create(LanguageDataSource::class, MysqlType::fromValue())->save($language);
    }
}