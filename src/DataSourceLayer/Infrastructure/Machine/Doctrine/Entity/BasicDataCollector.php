<?php

namespace App\DataSourceLayer\Infrastructure\Machine\Doctrine\Entity;

use App\Infrastructure\Machine\Collector\BasicDataCollectorInterface;
use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson;
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
use Library\Util\Util;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * @Entity @Table(
 *     name="basic_data_collector"
 * )
 * @HasLifecycleCallbacks()
 **/
class BasicDataCollector implements BasicDataCollectorInterface, DataSourceEntity, ArrayNotationInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var bool $accessed
     * @Column(type="boolean")
     */
    private $accessed;
    /**
     * @var int $accessedNum
     * @Column(type="integer")
     */
    private $accessedNum;
    /**
     * @var int $completedCount
     * @Column(type="integer")
     */
    private $completedCount;
    /**
     * @var int $uncompletedCount
     * @Column(type="integer")
     */
    private $uncompletedCount;
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
     * @param bool $accessed
     */
    public function setAccessed(bool $accessed): void
    {
        $this->accessed = $accessed;
    }
    /**
     * @return bool
     */
    public function getAccessed(): bool
    {
        return $this->accessed;
    }
    /**
     * @return int
     */
    public function getAccessedNum(): int
    {
        return $this->accessedNum;
    }
    /**
     * @param int $accessedNum
     */
    public function setAccessedNum(int $accessedNum): void
    {
        $this->accessedNum = $accessedNum;
    }
    /**
     * @return int
     */
    public function getCompletedCount(): int
    {
        return $this->completedCount;
    }
    /**
     * @param int $completedCount
     */
    public function setCompletedCount(int $completedCount): void
    {
        $this->completedCount = $completedCount;
    }
    /**
     * @return int
     */
    public function getUncompletedCount(): int
    {
        return $this->uncompletedCount;
    }
    /**
     * @param int $uncompletedCount
     */
    public function setUncompletedCount(int $uncompletedCount): void
    {
        $this->uncompletedCount = $uncompletedCount;
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
            'accessed' => $this->getAccessed(),
            'accessedNum' => $this->getAccessedNum(),
            'completedCount' => $this->getCompletedCount(),
            'uncompletedCount' => $this->getUncompletedCount(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}