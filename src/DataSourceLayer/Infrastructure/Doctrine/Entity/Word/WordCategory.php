<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Library\Util\Util;

/**
 * @Entity @Table(name="word_categories")
 * @HasLifecycleCallbacks()
 **/
class WordCategory
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var Word $word
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word")
     */
    private $word;
    /**
     * @var Category
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category")
     */
    private $category;
    /**
     * @var \DateTime $createdAt
     * @Column(type="datetime")
     */
    private $createdAt;
    /**
     * @var \DateTime $updatedAt
     * @Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * WordCategory constructor.
     * @param Word $word
     * @param Category $category
     */
    public function __construct(
        Word $word,
        Category $category
    ) {
        $this->word = $word;
        $this->category = $category;
    }
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
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @PrePersist()
     */
    public function handleDates(): void
    {
        if ($this->updatedAt instanceof \DateTime) {
            $this->setUpdatedAt(Util::toDateTime());
        }

        if (!$this->createdAt instanceof \DateTime) {
            $this->setCreatedAt(Util::toDateTime());
        }
    }
}