<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\WordCategory;
use App\DataSourceLayer\LearningMetadata\WordCategoryDataSourceService;
use App\DataSourceLayer\LearningMetadata\WordDataSourceService;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Word\Word;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Word as WordDataSource;
use App\LogicLayer\LearningMetadata\Domain\Word\Word as WordDomainModel;
use App\LogicLayer\LearningMetadata\Domain\Word\WordCategory as WordCategoryDomainModel;
use Library\Infrastructure\Helper\TypedArray;

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

        $domainWord = $this->serializerWrapper
            ->convertFromToByGroup($newWord, 'default', WordDomainModel::class);

        return [
            'word' => $domainWord,
            'wordCategories' => $wordCategories,
        ];
    }
    /**
     * @param iterable $wordCategories
     * @return iterable
     */
    private function createDomainWordCategories(iterable $wordCategories): iterable
    {
        $domainWordCategories = TypedArray::create('integer', WordCategoryDomainModel::class);
        /** @var WordCategory $wordCategory */
        foreach ($wordCategories as $wordCategory) {
            $domainWordCategories[] = $this->serializerWrapper
                ->convertFromToByGroup($wordCategory, 'default', WordCategoryDomainModel::class);
        }

        return $domainWordCategories;
    }
}