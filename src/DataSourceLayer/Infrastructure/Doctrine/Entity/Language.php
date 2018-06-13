<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\Mapping\Index;

/**
 * @Entity @Table(
 *     name="languages",
 *     uniqueConstraints={ @UniqueConstraint(columns={"name"}) },
 *     indexes={ @Index(name="language_name_idx", columns={"name"}) }
 * )
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
     * @var array $images
     * @Column(type="json_array")
     */
    private $images;
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
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }
    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
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
}