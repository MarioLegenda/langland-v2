<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
use Library\Infrastructure\Helper\ModelValidator;

class Category
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
     * @param DataSourceEntity|CategoryDataSource $category
     */
    public function create(DataSourceEntity $category)
    {
        $this->repositoryFactory
            ->create(CategoryDataSource::class, MysqlType::fromValue())
            ->save($category);
    }
    /**
     * @param DataSourceEntity|CategoryDataSource $category
     */
    public function createIfNotExists(DataSourceEntity $category)
    {
        $repository = $this->repositoryFactory->create(CategoryDataSource::class, MysqlType::fromValue());

        /** @var CategoryDataSource $existingCategory */
        $existingCategory = $repository->findOneBy([
            'name' => $category->getName(),
        ]);

        if ($existingCategory instanceof DataSourceEntity) {
            $message = sprintf(
                'Category with name \'%s\' already exists',
                $existingCategory->getName()
            );

            throw new \RuntimeException($message);
        }

        $this->create($category);
    }
}