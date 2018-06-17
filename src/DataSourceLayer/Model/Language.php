<?php

namespace App\DataSourceLayer\Model;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as DataSourceLanguage;
use Library\Util\Util;

class Language implements LayerPropagationResponse
{
    /**
     * @var DataSourceLanguage $language
     */
    private $language;
    /**
     * Language constructor.
     * @param DataSourceLanguage $language
     */
    public function __construct(DataSourceLanguage $language)
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
            'images' => $this->language->getImages(),
            'createdAt' => Util::formatFromDate($this->language->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->language->getUpdatedAt()),
        ];
    }
}