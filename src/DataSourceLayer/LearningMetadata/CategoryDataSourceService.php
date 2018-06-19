<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as CategoryDataSource;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use Library\Infrastructure\Helper\ModelValidator;

class CategoryDataSourceService
{
    /**
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * Language constructor.
     * @param CategoryRepository $categoryRepository
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ModelValidator $modelValidator
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->modelValidator = $modelValidator;
    }
    /**
     * @param DataSourceEntity|Category $category
     * @return DataSourceEntity|Category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createIfNotExists(DataSourceEntity $category): DataSourceEntity
    {
        /** @var CategoryDataSource $existingCategory */
        $existingCategory = $this->categoryRepository->findOneBy([
            'name' => $category->getName(),
        ]);

        if ($existingCategory instanceof DataSourceEntity) {
            $message = sprintf(
                'Category with name \'%s\' already exists',
                $existingCategory->getName()
            );

            throw new \RuntimeException($message);
        }

        return $this->categoryRepository->persistAndFlush($category);
    }
}