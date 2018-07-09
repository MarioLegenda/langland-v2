<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\OneToMany;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity @Table(
 *     name="lessons",
 * )
 * @HasLifecycleCallbacks()
 **/
class Lesson implements DataSourceEntity, ArrayNotationInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var string $name
     * @Column(type="string")
     */
    private $name;
    /**
     * @var string $locale
     * @Column(type="string")
     */
    private $locale;
    /**
     * @var LessonData[]|ArrayCollection $lessonData
     * @OneToMany(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\LessonData", mappedBy="lesson", cascade={"persist"})
     */
    private $lessonData;
    /**
     * @var Language $language
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language")
     * @JoinColumn(name="language_id", referencedColumnName="id")
     */
    private $language;
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
    public function getLocale(): string
    {
        return $this->locale;
    }
    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
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
     * @param LessonData $lessonData
     * @return Lesson
     */
    public function addLessonData(LessonData $lessonData): Lesson
    {
        $this->initializeLessonData();

        $lessonData->setLesson($this);

        $this->lessonData->add($lessonData);
    }
    /**
     * @return LessonData[]
     */
    public function getLessonData(): array
    {
        return $this->lessonData;
    }
    /**
     * @param LessonData[] $lessonData
     */
    public function setLessonData(array $lessonData): void
    {
        $this->initializeLessonData();

        /** @var LessonData $item */
        foreach ($lessonData as $item) {
            $item->setLesson($this);

            $this->lessonData->add($item);
        }
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
     * @return \DateTime|null
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
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'locale' => $this->getLocale(),
            'lessonData' => apply_on_iterable($this->getLessonData(), function(LessonData $lessonData) {
                return $lessonData->getName();
            }),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }

    private function initializeLessonData(): void
    {
        if (!$this->lessonData instanceof LessonData) {
            $this->lessonData = new ArrayCollection();
        }
    }
}