<?php

namespace App\PresentationLayer\Model\Word;

use App\Infrastructure\Model\CollectionEntity;
use App\PresentationLayer\Model\Language;
use App\PresentationLayer\Model\PresentationModelInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\PresentationLayer\Model\Image;

class Word implements PresentationModelInterface
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
     * @param CollectionEntity $categories
     */
    public function setCategories(CollectionEntity $categories)
    {
        $this->categories = $categories;
    }
    /**
     * @return CollectionEntity
     */
    public function getCategories(): CollectionEntity
    {
        return $this->categories;
    }
    /**
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        $validation = $this->getCategories()->validate();

        if (!$validation['valid']) {
            $context
                ->buildViolation($validation['messages'])
                ->addViolation();
        }
    }
}