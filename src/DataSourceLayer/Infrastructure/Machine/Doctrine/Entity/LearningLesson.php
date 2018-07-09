<?php

namespace App\DataSourceLayer\Infrastructure\Machine\Doctrine\Entity;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson;
use App\Infrastructure\Machine\Collector\BasicDataCollectorInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\Index;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Doctrine\ORM\Mapping\JoinColumn;
use Library\Util\Util;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * @Entity @Table(
 *     name="learning_lessons"
 * )
 * @HasLifecycleCallbacks()
 **/
class LearningLesson implements DataSourceEntity, ArrayNotationInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var BasicDataCollectorInterface|ArrayNotationInterface $dataCollector
     * @ManyToOne(targetEntity="App\Infrastructure\Machine\Collector\BasicDataCollectorInterface")
     * @JoinColumn(name="data_collector_id", referencedColumnName="id")
     */
    private $dataCollector;
    /**
     * @var Lesson $lesson
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson")
     */
    private $lesson;
    /**
     * @var \DateTime $createdAt
     * @Column(type="datetime", nullable=false)
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
     * @return BasicDataCollectorInterface
     */
    public function getDataCollector(): BasicDataCollectorInterface
    {
        return $this->dataCollector;
    }
    /**
     * @param BasicDataCollectorInterface $dataCollector
     */
    public function setDataCollector(BasicDataCollectorInterface $dataCollector): void
    {
        $this->dataCollector = $dataCollector;
    }
    /**
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }
    /**
     * @param Lesson $lesson
     */
    public function setLesson(Lesson $lesson): void
    {
        $this->lesson = $lesson;
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
            'dataCollector' => $this->dataCollector->toArray(),
            'lesson' => $this->lesson->toArray(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}