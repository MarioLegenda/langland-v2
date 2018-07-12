<?php

namespace App\DataSourceLayer\Infrastructure\Machine\Doctrine\Entity;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Machine\Doctrine\Entity\Game;
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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;

/**
 * @Entity @Table(
 *     name="game_blocks"
 * )
 * @HasLifecycleCallbacks()
 **/
class GameBlock implements DataSourceEntity, ArrayNotationInterface
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var string $type
     * @Column(type="string", nullable=false)
     */
    private $type;
    /**
     * @var Game $game
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Machine\Doctrine\Entity\Game")
     */
    private $game;
    /**
     * @var BasicDataCollectorInterface|ArrayNotationInterface $dataCollector
     * @ManyToOne(targetEntity="App\Infrastructure\Machine\Collector\BasicDataCollectorInterface")
     * @JoinColumn(name="data_collector_id", referencedColumnName="id")
     */
    private $basicDataCollector;
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
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }
    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }
    /**
     * @return BasicDataCollectorInterface|ArrayNotationInterface
     */
    public function getBasicDataCollector(): BasicDataCollectorInterface
    {
        return $this->basicDataCollector;
    }
    /**
     * @param BasicDataCollectorInterface|ArrayNotationInterface $basicDataCollector
     */
    public function setBasicDataCollector(BasicDataCollectorInterface $basicDataCollector): void
    {
        $this->basicDataCollector = $basicDataCollector;
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
    public function getUpdatedAt(): \DateTime
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
            'type' => $this->getType(),
            'game' => $this->getGame()->toArray(),
            'dataCollector' => $this->basicDataCollector->toArray(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}