<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CategoryRepository extends ServiceEntityRepository
{
    /**
     * CategoryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    /**
     * @param Category $language
     * @return Category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistAndFlush(Category $language): Category
    {
        $this->getEntityManager()->persist($language);
        $this->getEntityManager()->flush();

        return $language;
    }
}