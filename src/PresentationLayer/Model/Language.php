<?php

namespace App\PresentationLayer\Model;

use Library\Infrastructure\Notation\ArrayNotationInterface;

class Language implements PresentationModelInterface, ArrayNotationInterface
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
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => (is_int($this->id)) ? $this->getId() : null,
            'name' => $this->getName(),
            'showOnPage' => $this->getShowOnPage(),
            'description' => $this->getDescription(),
            'images' => $this->getImages(),
        ];
    }
}