<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;

class WordCategory
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var Word $word
     */
    private $word;
    /**
     * @var Category
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
     * @param Word $word
     */
    public function setWord(Word $word): void
    {
        $this->word = $word;
    }
    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }
    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}