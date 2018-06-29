<?php

namespace App\PresentationLayer\Infrastructure\Model;

use Library\Infrastructure\Notation\ArrayNotationInterface;

class Lesson implements PresentationModelInterface, ArrayNotationInterface
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
     * @var string $temporaryText
     */
    private $temporaryText;
    /**
     * @var Language $language
     */
    private $language;
    /**
     * @return int
     */
    public function getId()
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
     * @return string
     */
    public function getTemporaryText(): string
    {
        return $this->temporaryText;
    }
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'temporaryText' => $this->getTemporaryText(),
            'locale' => $this->getLocale(),
        ];
    }
}