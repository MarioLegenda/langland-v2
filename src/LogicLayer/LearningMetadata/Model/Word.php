<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Translation;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\WordCategory;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
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
            'language' => $this->getLanguage(),
            'description' => $this->word->getDescription(),
            'level' => $this->word->getLevel(),
            'pluralForm' => $this->word->getPluralForm(),
            'translations' => $this->getTranslations(),
            'wordCategories' => $this->getWordCategories(),
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
    /**
     * @return array
     */
    private function getTranslations(): array
    {
        $translations = $this->word->getTranslations();

        $array = [];
        /** @var Translation $translation */
        foreach ($translations as $translation) {
            $temp = [];

            $temp['id'] = $translation->getId();
            $temp['name'] = $translation->getName();
            $temp['valid'] = $translation->isValid();
            $temp['createdAt'] = Util::formatFromDate($translation->getCreatedAt());
            $temp['updatedAt'] = Util::formatFromDate($translation->getUpdatedAt());

            $array[] = $temp;
        }

        return $array;
    }
    /**
     * @return iterable
     */
    private function getWordCategories(): iterable
    {
        $categoryIds = [];
        /** @var WordCategory $wordCategory */
        foreach ($this->wordCategories as $wordCategory) {
            $categoryIds[] = $wordCategory->getCategory()->getId();
        }

        return $categoryIds;
    }
    /**
     * @return array
     */
    private function getLanguage(): array
    {
        return [
            'id' => $this->word->getLanguage()->getId(),
            'name' => $this->word->getLanguage()->getName(),
            'createdAt' => Util::formatFromDate($this->word->getLanguage()->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->word->getLanguage()->getUpdatedAt()),
        ];
    }
}