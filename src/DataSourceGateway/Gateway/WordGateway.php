<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Type\MysqlType;
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
     * WordGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param WordDataSourceService $wordDataSourceService
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        WordDataSourceService $wordDataSourceService
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->wordDataSourceService = $wordDataSourceService;
    }
    /**
     * @param DomainModelInterface|Word $domainModel
     * @return DomainModelInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        $categories = $domainModel->getCategories();
        /** @var WordDataSource $wordDataSource */
        $wordDataSource = $this->serializerWrapper->convertFromToByGroup(
            $domainModel,
            'default',
            WordDataSource::class
        );

        $wordDataSource->setCategories($categories);

        $this->modelValidator->validate($wordDataSource);

        $newWord = $this->wordDataSourceService->create($wordDataSource);
    }
}