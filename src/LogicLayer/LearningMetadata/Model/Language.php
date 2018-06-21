<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use Library\Util\Util;
use App\LogicLayer\LearningMetadata\Domain\Language as LanguageDomainModel;

class Language implements LayerPropagationResponse
{
    /**
     * @var DomainModelInterface|LanguageDomainModel $language
     */
    private $language;
    /**
     * Language constructor.
     * @param DomainModelInterface|Language $language
     */
    public function __construct(DomainModelInterface $language)
    {
        $this->language = $language;
    }
    /**
     * @return Language
     */
    public function getPropagationObject(): object
    {
        return $this->language;
    }
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->language->getId(),
            'name' => $this->language->getName(),
            'showOnPage' => $this->language->isShowOnPage(),
            'description' => $this->language->getDescription(),
            'image' => [
                'id' => $this->language->getImage()->getId(),
                'name' => $this->language->getImage()->getName(),
                'relativePath' => $this->language->getImage()->getRelativePath(),
            ],
            'createdAt' => Util::formatFromDate($this->language->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->language->getUpdatedAt()),
        ];
    }
}