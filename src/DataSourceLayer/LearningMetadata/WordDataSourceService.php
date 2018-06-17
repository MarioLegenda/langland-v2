<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Image;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\ImageRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\WordRepository;
use App\DataSourceLayer\Infrastructure\RepositoryFactory;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;

class WordDataSourceService
{
    /**
     * @var RepositoryFactory $repositoryFactory
     */
    private $repositoryFactory;
    /**
     * WordDataSourceService constructor.
     * @param RepositoryFactory $repositoryFactory
     */
    public function __construct(
        RepositoryFactory $repositoryFactory
    ) {
        $this->repositoryFactory = $repositoryFactory;
    }
    /**
     * @param DataSourceEntity|Word $wordDataSourceEntity
     * @return DataSourceEntity
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DataSourceEntity $wordDataSourceEntity): DataSourceEntity
    {
        /** @var Image $image */
        $image = $wordDataSourceEntity->getImage();

        /** @var ImageRepository $imageRepository */
        $imageRepository = $this->repositoryFactory->create(Image::class, MysqlType::fromValue());
        /** @var WordRepository $wordRepository */
        $wordRepository = $this->repositoryFactory->create(Word::class, MysqlType::fromValue());
        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = $this->repositoryFactory->create(Category::class, MysqlType::fromValue());

        $imageRepository->markToBeSaved($image);

        /** @var Word $newWord */
        $newWord = $wordRepository->save($wordDataSourceEntity);

        return $newWord;
    }
}