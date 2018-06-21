<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\WordCategory;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\WordCategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\WordRepository;
use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;

class WordCategoryDataSourceService
{
    /**
     * @var WordCategoryRepository $wordCategoryRepository
     */
    private $wordCategoryRepository;
    /**
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;
    /**
     * @var WordRepository $wordRepository
     */
    private $wordRepository;
    /**
     * WordCategoryDataSourceService constructor.
     * @param WordCategoryRepository $wordCategoryRepository
     * @param CategoryRepository $categoryRepository
     * @param WordRepository $wordRepository
     */
    public function __construct(
        WordCategoryRepository $wordCategoryRepository,
        CategoryRepository $categoryRepository,
        WordRepository $wordRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->wordCategoryRepository = $wordCategoryRepository;
        $this->wordRepository = $wordRepository;
    }
    /**
     * @param $word
     * @param $category
     * @throws \Doctrine\ORM\ORMException
     */
    public function createFromWordAndCategory($word, $category)
    {
        $word = $this->getWord($word);
        $category = $this->getCategory($category);

        $wordCategory = new WordCategory($word, $category);

        $this->wordCategoryRepository->persistAndFlush($wordCategory);
    }
    /**
     * @param $word
     * @param CollectionEntity $categories
     * @return iterable
     * @throws \Doctrine\ORM\ORMException
     */
    public function handleCollectionEntity($word, CollectionEntity $categories): iterable
    {
        $word = $this->getWord($word);
        $createdCategories = [];

        /** @var CollectionMetadata $metadata */
        foreach ($categories as $metadata) {
            $category = $this->getCategory($metadata->getId());

            switch ($metadata->getAction()->getValue()) {
                case 'create':
                    $wordCategory = $this->createObjectFromWordAndCategory($word, $category);

                    $createdCategories[] = $this->wordCategoryRepository->persist($wordCategory);
            }
        }

        $this->wordCategoryRepository->saveAll();

        return $createdCategories;
    }
    /**
     * @param $word
     * @param $category
     * @return WordCategory
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function createObjectFromWordAndCategory($word, $category): WordCategory
    {
        $word = $this->getWord($word);
        $category = $this->getCategory($category);

        return new WordCategory($word, $category);
    }
    /**
     * @param Category|int $category
     * @return Category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    private function getCategory($category): Category
    {
        if (!$category instanceof DataSourceEntity and !is_int($category)) {
            $message = sprintf(
                'Invalid argument. $category can only be an id of a category or a %s instance',
                DataSourceEntity::class
            );

            throw new \RuntimeException($message);
        }

        if (is_int($category)) {
            /** @var Category $foundCategory */
            $foundCategory = $this->categoryRepository->find($category);

            return $foundCategory;
        }

        return $category;
    }
    /**
     * @param int|Word $word
     * @return Word
     */
    private function getWord($word): Word
    {
        if (!$word instanceof DataSourceEntity and !is_int($word)) {
            $message = sprintf(
                'Invalid argument. $word can only be an id of a word or a %s instance',
                DataSourceEntity::class
            );

            throw new \RuntimeException($message);
        }

        if (is_int($word)) {
            /** @var Word $foundWord */
            $foundWord = $this->wordRepository->find($word);

            return $foundWord;
        }

        return $word;
    }
}