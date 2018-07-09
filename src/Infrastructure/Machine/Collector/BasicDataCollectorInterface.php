<?php

namespace App\Infrastructure\Machine\Collector;

interface BasicDataCollectorInterface
{
    /**
     * @param bool $accessed
     */
    public function setAccessed(bool $accessed): void;
    /**
     * @return bool
     */
    public function getAccessed(): bool;
    /**
     * @param int $num
     */
    public function setAccessedNum(int $num): void;
    /**
     * @return int
     */
    public function getAccessedNum(): int;
    /**
     * @param int $count
     */
    public function setCompletedCount(int $count): void;
    /**
     * @return int
     */
    public function getCompletedCount(): int;
    /**
     * @param int $count
     */
    public function setUncompletedCount(int $count): void;
    /**
     * @return int
     */
    public function getUncompletedCount(): int;
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void;
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void;
    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime;
}