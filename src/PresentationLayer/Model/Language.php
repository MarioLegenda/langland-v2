<?php

namespace App\PresentationLayer\Model;

class Language implements PresentationModelInterface
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
     * @var array $images
     */
    private $images;
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
     * @return bool
     */
    public function getShowOnPage()
    {
        return $this->showOnPage;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }
}