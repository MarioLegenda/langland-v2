<?php

namespace App\LogicLayer\Machine\Kernel;

use App\DataSourceLayer\LearningMetadata\WordDataSourceService;
use App\Infrastructure\Machine\Kernel\RandomWordGeneratorInterface;
use App\Library\Infrastructure\CollectionInterface;

class RandomWordGenerator implements RandomWordGeneratorInterface
{
    /**
     * @var WordDataSourceService $wordDataSourceService
     */
    private $wordDataSourceService;
    /**
     * RandomWordGenerator constructor.
     * @param WordDataSourceService $wordDataSourceService
     */
    public function __construct(
        WordDataSourceService $wordDataSourceService
    ) {
        $this->wordDataSourceService = $wordDataSourceService;
    }
    /**
     * @param CollectionInterface $excludeList
     * @return CollectionInterface
     */
    public function getWords(CollectionInterface $excludeList): CollectionInterface
    {

    }
}