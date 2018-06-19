<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine\Repository;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class WordRepository extends ServiceEntityRepository
{
    /**
     * WordRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Word::class);
    }
}