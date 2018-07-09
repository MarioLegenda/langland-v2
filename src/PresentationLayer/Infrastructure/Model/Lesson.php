<?php

namespace App\PresentationLayer\Infrastructure\Model;

use Library\Infrastructure\Notation\ArrayNotationInterface;

class Lesson implements PresentationModelInterface, ArrayNotationInterface
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
     * @var string $locale
     */
    private $locale;
    /**
     * @var iterable $lessonData
     */
    private $lessonData;
    /**
     * @var string $internalName
     */
    private $internalName;
    /**
     * @var Language $language
     */
    private $language;
    /**
     * @return int
     */
    public function getId()
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
    public function getInternalName(): string
    {
        return $this->internalName;
    }
    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }
    /**
     * @return iterable
     */
    public function getLessonData(): iterable
    {
        return $this->lessonData;
    }
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'locale' => $this->getLocale(),
            'internalName' => $this->getInternalName(),
            'lessonData' => apply_on_iterable($this->getLessonData(), function(LessonData $lessonData) {
                return $lessonData->getName();
            }),
        ];
    }
}