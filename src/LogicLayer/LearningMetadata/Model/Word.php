<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\LogicLayer\LearningMetadata\Domain\Word\Translation;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\WordCategory;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Word\Word as WordDomainModel;
use Library\Util\Util;

class Word implements LayerPropagationResourceResponse
{
    /**
     * @var WordDomainModel $word
     */
    private $word;
    /**
     * @var WordCategory[] $wordCategories
     */
    private $wordCategories;
    /**
     * Word constructor.
     * @param DomainModelInterface|WordDomainModel $word
     * @param iterable|WordCategory[] $wordCategories
     */
    public function __construct(
        WordDomainModel $word,
        iterable $wordCategories
    ) {
        $this->word = $word;
        $this->wordCategories = $wordCategories;
    }
    /**
     * @return Word
     */
    public function getPropagationObject(): object
    {
        return $this->word;
    }
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->word->getId(),
            'name' => $this->word->getName(),
            'type' => $this->word->getType(),
            'language' => $this->word->getLanguage()->toArray(),
            'description' => $this->word->getDescription(),
            'level' => $this->word->getLevel(),
            'pluralForm' => $this->word->getPluralForm(),
            'translations' => apply_on_iterable($this->word->getTranslations(), function(Translation $value) {
                return $value->toArray();
            }),
            'wordCategories' => apply_on_iterable($this->wordCategories, function(WordCategory $wordCategory) {
                return $wordCategory->getCategory()->getId();
            }),
            'image' => [
                'id' => $this->word->getImage()->getId(),
                'name' => $this->word->getImage()->getName(),
                'relativePath' => $this->word->getImage()->getRelativePath(),
                'createdAt' => Util::formatFromDate($this->word->getImage()->getCreatedAt()),
                'updatedAt' => Util::formatFromDate($this->word->getImage()->getUpdatedAt()),
            ],
            'createdAt' => Util::formatFromDate($this->word->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->word->getUpdatedAt()),
        ];
    }
}