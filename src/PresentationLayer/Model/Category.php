<?php

namespace App\PresentationLayer\Model;

use Library\Infrastructure\Notation\ArrayNotationInterface;

class Category implements PresentationModelInterface, ArrayNotationInterface
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
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}