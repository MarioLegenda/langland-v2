<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\DataSourceEntity;
use App\DataSourceLayer\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\RepositoryFactory;
use App\DataSourceLayer\Type\MysqlType;

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