<?php

namespace App\PresentationLayer\Infrastructure\Model\Word;

use App\Infrastructure\Model\CollectionEntity;
use App\PresentationLayer\Infrastructure\Model\Language;
use App\PresentationLayer\Infrastructure\Model\Lesson;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\PresentationLayer\Infrastructure\Model\Image;

class Word implements PresentationModelInterface, ArrayNotationInterface
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
     * @var Lesson $lesson
     */
    private $lesson;
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
     * @return Lesson
     */
    public function getLesson(): ?Lesson
    {
        return $this->lesson;
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
            'lesson' => ($this->getLesson() instanceof Lesson) ? $this->getLesson()->toArray() : null,
            'level' => $this->getLevel(),
            'pluralForm' => $this->getPluralForm(),
        ];
    }
}