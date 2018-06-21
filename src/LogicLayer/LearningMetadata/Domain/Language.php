<?php

namespace App\LogicLayer\LearningMetadata\Domain;

use Library\Util\Util;
use App\LogicLayer\LearningMetadata\Domain\Image as DomainImage;

class Language implements DomainModelInterface
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
     * @var bool $showOnPage
     */
    private $showOnPage;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var Image $image
     */
    private $image;
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
    public function getId(): int
    {
        return $this->id;
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
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @param bool $showOnPage
     */
    public function setShowOnPage(bool $showOnPage): void
    {
        $this->showOnPage = $showOnPage;
    }
    /**
     * @return bool
     */
    public function isShowOnPage(): bool
    {
        return $this->showOnPage;
    }
    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @return DomainImage
     */
    public function getImage(): DomainImage
    {
        return $this->image;
    }

    /**
     * @param DomainImage $image
     */
    public function setImage(DomainImage $image): void
    {
        $this->image = $image;
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