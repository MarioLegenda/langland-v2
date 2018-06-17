<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\PresentationLayer\Model\Word\Categories;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Index;

/**
 * @Entity @Table(
 *     name="words",
 *     indexes={ @Index(name="word_name_idx", columns={"name"}) }
 * )
 **/
class Word implements DataSourceEntity
{
    /**
     * @var int $id
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var string $name
     * @Column(type="string")
     */
    private $name;
    /**
     * @var string $type
     * @Column(type="string")
     */
    private $type;
    /**
     * @var Language $language
     * @ORM\ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language")
     */
    private $language;
    /**
     * @var string $description
     * @Column(type="string")
     */
    private $description;
    /**
     * @var int $level
     * @Column(type="integer")
     */
    private $level;
    /**
     * @var string $pluralForm
     * @Column(type="string")
     */
    private $pluralForm;

    /**
     * @var ArrayCollection $translations
     * @OneToMany(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Translation", mappedBy="product", cascade={"persist"})
     */
    private $translations;
    /**
     * @var Image $image
     * @ORM\ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Image")
     */
    private $image;
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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
    /**
     * @return string
     */
    public function getPluralForm(): string
    {
        return $this->pluralForm;
    }
    /**
     * @param Translation $translation
     */
    public function addTranslation(Translation $translation): void
    {
        $translation->setWord($this);

        $this->translations->add($translation);
    }
    /**
     * @return iterable
     */
    public function getTranslations(): iterable
    {
        return $this->translations;
    }
    /**
     * @param Category $category
     * @return Word
     */
    public function addCategory(Category $category): Word
    {
        $this->categories->add($category);

        return $this;
    }
    /**
     * @param Categories $categories
     */
    public function setCategories(iterable $categories): void
    {
        $this->initializeCategories();

        foreach ($categories as $category) {
            $this->categories->add($category);
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }
    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }
    /**
     * @param Image $image
     */
    public function setImage(Image $image): void
    {
        $this->image = $image;
    }

    private function initializeCategories(): void
    {
        if (!$this->categories instanceof ArrayCollection) {
            $this->categories = new ArrayCollection();
        }
    }
}