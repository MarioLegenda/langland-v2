<?php

namespace App\Tests\PresentationLayer;

use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\Model\Category;
use App\Tests\Library\BasicSetup;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;

class CategoryEntryPointTest extends BasicSetup
{
    public function test_category_create_success()
    {
        static::markTestSkipped();

        $presentationModelDataProvider = static::$container->get(PresentationModelDataProvider::class);

        $categoryEntryPoint = static::$container->get(CategoryEntryPoint::class);
        /** @var Category $categoryModel */
        $categoryModel = $presentationModelDataProvider->getCategoryModel();

        static::assertNotEmpty($categoryModel->getName());

        $categoryEntryPoint->create($categoryModel);
    }
}