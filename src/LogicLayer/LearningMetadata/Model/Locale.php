<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\Locale as LocaleDomainModel;
use Library\Util\Util;

class Locale implements LayerPropagationResourceResponse
{
    /**
     * @var LocaleDomainModel $locale
     */
    private $locale;
    /**
     * Lesson constructor.
     * @param LocaleDomainModel $locale
     */
    public function __construct(
        LocaleDomainModel $locale
    ) {
        $this->locale = $locale;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->locale->getId(),
            'name' => $this->locale->getName(),
            'createdAt' => Util::formatFromDate($this->locale->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->locale->getUpdatedAt()),
        ];
    }
    /**
     * @return object|LocaleDomainModel
     */
    public function getPropagationObject(): object
    {
        return $this->locale;
    }
}