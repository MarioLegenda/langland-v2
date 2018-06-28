<?php

namespace App\LogicLayer\LearningMetadata\Domain;

use App\LogicLayer\LearningMetadata\Domain\Image as DomainImage;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;

class Language implements DomainModelInterface, ArrayNotationInterface
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
     * @param bool $showOnPage
     */
    public function setShowOnPage(bool $showOnPage): void
    {
        $this->showOnPage = $showOnPage;
    }
    /**
     * @return bool
     */
    public function getShowOnPage(): bool
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
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => (is_int($this->id)) ? $this->getId() : null,
            'name' => $this->getName(),
            'locale' => $this->getLocale(),
            'showOnPage' => $this->getShowOnPage(),
            'description' => $this->getDescription(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}