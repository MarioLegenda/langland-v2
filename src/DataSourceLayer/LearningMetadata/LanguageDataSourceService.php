<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
use Library\Infrastructure\Helper\ModelValidator;

class LanguageDataSourceService
{
    /**
     * @var RepositoryFactory $repositoryFactory
     */
    private $repositoryFactory;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * Language constructor.
     * @param RepositoryFactory $repositoryFactory
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        RepositoryFactory $repositoryFactory,
        ModelValidator $modelValidator
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->modelValidator = $modelValidator;
    }
    /**
     * @param DataSourceEntity|LanguageDataSource $language
     */
    public function create(DataSourceEntity $language)
    {
        $this->repositoryFactory
            ->create(LanguageDataSource::class, MysqlType::fromValue())
            ->save($language);
    }
    /**
     * @param DataSourceEntity|LanguageDataSource $language
     */
    public function createIfNotExists(DataSourceEntity $language)
    {
        $repository = $this->repositoryFactory->create(LanguageDataSource::class, MysqlType::fromValue());

        /** @var LanguageDataSource $existingLanguage */
        $existingLanguage = $repository->findOneBy([
            'name' => $language->getName(),
        ]);

        if ($existingLanguage instanceof DataSourceEntity) {
            $message = sprintf(
                'Language with name \'%s\' already exists',
                $existingLanguage->getName()
            );

            throw new \RuntimeException($message);
        }

        $this->create($language);
    }
}