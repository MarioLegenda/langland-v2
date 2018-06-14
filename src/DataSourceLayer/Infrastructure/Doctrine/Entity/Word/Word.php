<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use Doctrine\Common\Collections\ArrayCollection;

class Word
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
     * @var string $type
     */
    private $type;
    /**
     * @var Language $language
     */
    private $language;
    /**
     * @var string $description
     */
    private $description;
    /**
     * @var int $level
     */
    private $level;
    /**
     * @var string $pluralForm
     */
    private $pluralForm;
    /**
     * @var ArrayCollection $categories
     */
    private $categories;
    /**
     * @var Translation[] $translations
     */
    private $translations;
    /**
     * @var Image $image
     */
    private $image;
}