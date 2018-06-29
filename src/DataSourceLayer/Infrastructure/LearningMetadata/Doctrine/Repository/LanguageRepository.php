<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class LanguageRepository extends ServiceEntityRepository
{
    /**
     * LanguageRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }
    /**
     * @param Language $language
     * @return Language
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistAndFlush(Language $language): Language
    {
        $this->getEntityManager()->persist($language);
        $this->getEntityManager()->flush();

        return $language;
    }
}