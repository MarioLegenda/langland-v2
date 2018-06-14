<?php

namespace App\PresentationLayer\Model\Word;

use App\PresentationLayer\Model\Language;

class Word
{
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
     * @var iterable $categories
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
    /**
     * @return string
     */
    public function getPluralForm(): string
    {
        return $this->pluralForm;
    }
    /**
     * @return iterable
     */
    public function getCategories(): iterable
    {
        return $this->categories;
    }
    /**
     * @return Translation[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }
    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }
}