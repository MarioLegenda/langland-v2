<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Image;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Library\Infrastructure\Notation\ArrayNotationInterface;
use Library\Util\Util;

/**
 * @Entity @Table(
 *     name="words",
 *     indexes={ @Index(name="word_name_idx", columns={"name"}) }
 * )
 * @HasLifecycleCallbacks()
 **/
class Word implements DataSourceEntity, ArrayNotationInterface
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
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language")
     * @JoinColumn(name="language_id", referencedColumnName="id")
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
     * @OneToMany(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Translation", mappedBy="product", cascade={"persist"})
     */
    private $translations;
    /**
     * @var Image $image
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;
    /**
     * @var \DateTime $createdAt
     * @Column(type="datetime")
     */
    private $createdAt;
    /**
     * @var \DateTime $updatedAt
     * @Column(type="datetime", nullable=true)
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
     * @param Language $language
     */
    public function setLanguage(Language $language): void
    {
        $this->language = $language;
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
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
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
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @PrePersist()
     */
    public function handleDates(): void
    {
        if ($this->updatedAt instanceof \DateTime) {
            $this->setUpdatedAt(Util::toDateTime());
        }

        if (!$this->createdAt instanceof \DateTime) {
            $this->setCreatedAt(Util::toDateTime());
        }
    }
    /**
     * @PrePersist()
     */
    public function handleTranslationsConnection()
    {
        /** @var Translation $translation */
        foreach ($this->translations as $translation) {
            $translation->setWord($this);
        }
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'level' => $this->getLevel(),
            'pluralForm' => $this->getPluralForm(),
            'createdAt' => Util::formatFromDate($this->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->getUpdatedAt()),
        ];
    }
}