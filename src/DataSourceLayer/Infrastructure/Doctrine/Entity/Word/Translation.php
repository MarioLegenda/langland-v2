<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity @Table(
 *     name="word_translations",
 * )
 **/
class Translation implements DataSourceEntity
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
     * @var bool $valid
     * @Column(type="boolean")
     */
    private $valid;
    /**
     * @var Word $word
     * @ManyToOne(targetEntity="App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word", inversedBy="translations")
     * @JoinColumn(name="word_id", referencedColumnName="id")
     */
    private $word;
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }
    /**
     * @param bool $valid
     */
    public function setValid(bool $valid): void
    {
        $this->valid = $valid;
    }
    /**
     * @return Word
     */
    public function getWord(): Word
    {
        return $this->word;
    }
    /**
     * @param Word $word
     */
    public function setWord(Word $word): void
    {
        $this->word = $word;
    }
}