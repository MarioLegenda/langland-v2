<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\Index;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Image;
use Library\Util\Util;

/**
 * @Entity @Table(
 *     name="languages",
 *     uniqueConstraints={ @UniqueConstraint(columns={"name"}) },
 *     indexes={ @Index(name="language_name_idx", columns={"name"}) }
 * )
 * @HasLifecycleCallbacks()
 **/
class Language implements DataSourceEntity
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;
    /**
     * @var string $name
     * @Column(type="string", unique=true)
     */
    protected $name;
    /**
     * @var bool $showOnPage
     * @Column(type="boolean")
     */
    private $showOnPage;
    /**
     * @var string $description
     * @Column(type="string")
     */
    private $description;
    /**
     * @var Image $image
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
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
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
    /**
     * @return bool
     */
    public function isShowOnPage(): bool
    {
        return $this->showOnPage;
    }
    /**
     * @param bool $showOnPage
     */
    public function setShowOnPage(bool $showOnPage): void
    {
        $this->showOnPage = $showOnPage;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }
    /**
     * @param  $image
     */
    public function setImage(Image $image): void
    {
        $this->image = $image;
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
}