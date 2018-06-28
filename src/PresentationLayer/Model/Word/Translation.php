<?php

namespace App\PresentationLayer\Model\Word;

use App\PresentationLayer\Model\PresentationModelInterface;
use Library\Infrastructure\Notation\ArrayNotationInterface;

class Translation implements PresentationModelInterface, ArrayNotationInterface
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
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
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
            'locale' => $this->getLocale(),
        ];
    }
}