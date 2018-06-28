<?php

namespace App\LogicLayer\LearningMetadata\Domain\Word;

use App\Infrastructure\Model\CollectionEntity;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Language;
use App\LogicLayer\LearningMetadata\Domain\Image;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;

class Word implements DomainModelInterface, ArrayNotationInterface
{
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var Language $language
     */
    private $language;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var int $level
     */
    private $level;
    /**
     * @var string $pluralForm
     */
    private $pluralForm;
    /**
     * @var CollectionEntity $categories
     */
    private $categories;
    /**
     * @var Translation[] $translations
     */
    private $translations;
    /**
     * @var Image $image
     */
    private $image;
    /**
     * @var \DateTime $createdAt
     */
    private $createdAt;
    /**
     * @var \DateTime $updatedAt
     */
    private $updatedAt;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
    /**
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }
    /**
     * @return string
     */
    public function getPluralForm(): string
    {
        return $this->pluralForm;
    }
    /**
     * @param string $pluralForm
     */
    public function setPluralForm(string $pluralForm): void
    {
        $this->pluralForm = $pluralForm;
    }
    /**
     * @return CollectionEntity
     */
    public function getCategories(): CollectionEntity
    {
        return $this->categories;
    }
    /**
     * @param CollectionEntity $categories
     */
    public function setCategories(CollectionEntity $categories)
    {
        $this->categories = $categories;
    }
    /**
     * @return Translation[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }
    /**
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }
    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
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
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'level' => $this->getLevel(),
            'pluralForm' => $this->getPluralForm(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}