<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\WordCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class WordCategoryRepository extends ServiceEntityRepository
{
    /**
     * WordCategoryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordCategory::class);
    }
    /**
     * @param WordCategory $wordCategory
     * @return WordCategory
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistAndFlush(WordCategory $wordCategory): WordCategory
    {
        $this->getEntityManager()->persist($wordCategory);
        $this->getEntityManager()->flush();

        return $wordCategory;
    }
    /**
     * @param WordCategory $wordCategory
     * @return WordCategory
     * @throws \Doctrine\ORM\ORMException
     */
    public function persist(WordCategory $wordCategory): WordCategory
    {
        $this->getEntityManager()->persist($wordCategory);

        return $wordCategory;
    }
    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveAll()
    {
        $this->getEntityManager()->flush();
    }
}