<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\WordCategory;
use App\DataSourceLayer\LearningMetadata\WordCategoryDataSourceService;
use App\DataSourceLayer\LearningMetadata\WordDataSourceService;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Word\Word;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Word\Word as WordDataSource;

class WordGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var WordDataSourceService $wordDataSourceService
     */
    private $wordDataSourceService;
    /**
     * @var WordCategoryDataSourceService $wordCategoryDataSource
     */
    private $wordCategoryDataSource;
    /**
     * WordGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param WordDataSourceService $wordDataSourceService
     * @param WordCategoryDataSourceService $wordCategoryDataSource
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        WordDataSourceService $wordDataSourceService,
        WordCategoryDataSourceService $wordCategoryDataSource
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->wordDataSourceService = $wordDataSourceService;
        $this->wordCategoryDataSource = $wordCategoryDataSource;
    }
    /**
     * @param DomainModelInterface|Word $domainModel
     * @return iterable
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DomainModelInterface $domainModel): iterable
    {
        $categories = $domainModel->getCategories();

        /** @var WordDataSource $wordDataSource */
        $wordDataSource = $this->serializerWrapper->convertFromToByGroup(
            $domainModel,
            'default',
            WordDataSource::class
        );

        /** @var WordDataSource $newWord */
        $newWord = $this->wordDataSourceService->create($wordDataSource);

        /** @var WordCategory[] $wordCategories */
        $wordCategories = $this->wordCategoryDataSource->handleCollectionEntity(
            $newWord,
            $categories
        );

        return [
            'word' => $newWord,
            'wordCategories' => $wordCategories,
        ];
    }
}