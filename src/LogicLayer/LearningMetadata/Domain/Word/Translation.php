<?php

namespace App\LogicLayer\LearningMetadata\Domain\Word;

use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use Library\Infrastructure\Notation\ArrayNotationInterface;

class Translation implements DomainModelInterface, ArrayNotationInterface
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
     * @var bool $valid
     */
    private $valid;
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
    public function isValid(): bool
    {
        return $this->valid;
    }
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => (is_int($this->id)) ? $this->getId() : null,
            'name' => $this->getName(),
            'valid' => $this->isValid(),
        ];
    }
}