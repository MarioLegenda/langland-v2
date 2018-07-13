<?php

namespace App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\WordRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class WordRepository extends ServiceEntityRepository implements WordRepositoryInterface
{
    /**
     * WordRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }
    /**
     * @param Word $word
     * @return Word
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistAndFlush(Word $word): Word
    {
        $this->getEntityManager()->persist($word);
        $this->getEntityManager()->flush();

        return $word;
    }
    /**
     * @return int
     */
    public function getWordTotalCount(): int
    {
        $wrappedConnection = $this->getEntityManager()->getConnection()->getWrappedConnection();
    }
}