<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\LearningMetadata\LanguageDataSourceService;
use App\Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language as LanguageDataSource;
use App\LogicLayer\LearningMetadata\Domain\Language as LanguageDomainModel;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class LanguageGateway
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
     * @var LanguageDataSourceService $languageDataSourceService
     */
    private $languageDataSourceService;
    /**
     * LanguageGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param LanguageDataSourceService $languageDataSourceService
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        LanguageDataSourceService $languageDataSourceService
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->languageDataSourceService = $languageDataSourceService;
    }
    /**
     * @param DomainModelInterface $domainModel
     * @return DomainModelInterface|LanguageDomainModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        /** @var DataSourceEntity $dataSourceModel */
        $dataSourceModel = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', LanguageDataSource::class);

        $newLanguage = $this->languageDataSourceService->createIfNotExists($dataSourceModel);

        /** @var LanguageDomainModel $domainModel */
        $domainModel = $this->serializerWrapper
            ->convertFromToByGroup($newLanguage, 'default', LanguageDomainModel::class);

        $this->modelValidator->validate($domainModel);

        return $domainModel;
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return DomainModelInterface[]|iterable
     */
    public function getLanguages(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): iterable
    {
        $languages = $this->languageDataSourceService->getLanguages($paginatedInternalizedRequest);

        $this->modelValidator->bulkValidate($languages);

        /** @var DomainModelInterface[]|LanguageDomainModel[] $domainModels */
        $domainModels = $this->serializerWrapper->convertCollectionByGroup(
            $languages,
            'default',
            LanguageDomainModel::class
        );

        return $domainModels;
    }
}