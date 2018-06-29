<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class LocaleRepository extends ServiceEntityRepository
{
    /**
     * LocaleRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Locale::class);
    }
    /**
     * @param Locale $locale
     * @return Locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistAndFlush(Locale $locale): Locale
    {
        $this->getEntityManager()->persist($locale);
        $this->getEntityManager()->flush();

        return $locale;
    }
}