<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category as DataSourceCategory;
use Library\Util\Util;

class Category implements LayerPropagationResponse
{
    /**
     * @var DataSourceCategory $category
     */
    private $category;
    /**
     * @param DataSourceCategory $category
     * Category constructor.
     */
    public function __construct(DataSourceCategory $category)
    {
        $this->category = $category;
    }
    /**
     * @return iterable
     */
    public function toArray(): iterable
    {
        return [
            'id' => $this->category->getId(),
            'name' => $this->category->getName(),
            'createdAt' => Util::formatFromDate($this->category->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->category->getUpdatedAt()),
        ];
    }
    /**
     * @return DataSourceCategory
     */
    public function getPropagationObject(): object
    {
        return $this->category;
    }
}