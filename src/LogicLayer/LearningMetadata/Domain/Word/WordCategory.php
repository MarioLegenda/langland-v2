<?php

namespace App\LogicLayer\LearningMetadata\Domain\Word;

use App\LogicLayer\LearningMetadata\Domain\Category;

class WordCategory
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var Word $wordId
     */
    private $word;
    /**
     * @var Category $categoryId
     */
    private $category;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return Word
     */
    public function getWord(): Word
    {
        return $this->word;
    }
    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
}