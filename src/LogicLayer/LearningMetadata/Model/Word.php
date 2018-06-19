<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Translation;
use App\Infrastructure\Response\LayerPropagationResponse;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word as WordDataSource;

class Word implements LayerPropagationResponse
{
    /**
     * @var Word $word
     */
    private $word;
    /**
     * Word constructor.
     * @param WordDataSource $word
     */
    public function __construct(WordDataSource $word)
    {
        $this->word = $word;
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
            'language' => $this->word->getLanguage()->getId(),
            'description' => $this->word->getDescription(),
            'level' => $this->word->getLevel(),
            'pluralForm' => $this->word->getPluralForm(),
            'translations' => $this->getTranslations(),
            'image' => [
                'id' => $this->word->getImage()->getId(),
                'name' => $this->word->getImage()->getName(),
                'relativePath' => $this->word->getImage()->getRelativePath(),
            ],
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

            $array[] = $temp;
        }

        return $array;
    }
}