<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @param iterable $categories
     * @return iterable
     */
    public function findCategoriesInBulkById(iterable $categories): iterable
    {
        $qb = $this->createQueryBuilder('c');

        $ids = [];
        /** @var DataSourceEntity|Category $category */
        foreach ($categories as $category) {
            $ids[] = $category->getId();
        }

        return $qb
            ->andWhere('c.id IN (:ids)')
            ->setParameters([
                'ids' => $ids,
            ])
            ->getQuery()
            ->getResult();
    }
}