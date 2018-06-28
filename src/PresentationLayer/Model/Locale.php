<?php

namespace App\PresentationLayer\Model;

use Library\Infrastructure\Notation\ArrayNotationInterface;

class Locale implements PresentationModelInterface, ArrayNotationInterface
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
     * @var bool $default
     */
    private $default;
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
    public function isDefault(): bool
    {
        return $this->default;
    }
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'default' => $this->isDefault(),
        ];
    }
}