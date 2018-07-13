<?php

namespace App\LogicLayer\LearningMetadata\Domain;

use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;
use App\LogicLayer\DomainModelInterface;

class Lesson implements DomainModelInterface, ArrayNotationInterface
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
     * @var string $learningType
     */
    private $learningType;
    /**
     * @var Language $language
     */
    private $language;
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
    public function getLearningType(): string
    {
        return $this->learningType;
    }
    /**
     * @param string $learningType
     */
    public function setLearningType(string $learningType): void
    {
        $this->learningType = $learningType;
    }
    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
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
    public function getInternalName(): string
    {
        return $this->internalName;
    }
    /**
     * @param string $internalName
     */
    public function setInternalName(string $internalName): void
    {
        $this->internalName = $internalName;
    }
    /**
     * @return iterable
     */
    public function getLessonData(): iterable
    {
        return $this->lessonData;
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
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
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
            'learningType' => $this->getLearningType(),
            'lessonData' => apply_on_iterable($this->getLessonData(), function(LessonData $lessonData) {
                return $lessonData->getName();
            }),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}