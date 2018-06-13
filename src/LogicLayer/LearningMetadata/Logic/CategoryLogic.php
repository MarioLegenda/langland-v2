<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\LogicLayer\LearningMetadata\Domain\Category;
use App\LogicLayer\LogicInterface;

class CategoryLogic implements LogicInterface
{
    public function create(Category $category)
    {
        $category->handleDates();
    }
}