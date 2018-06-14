<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\LearningMetadata\LanguageDataSourceService;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;
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
     */
    public function create(DomainModelInterface $domainModel)
    {
        /** @var DataSourceEntity $dataSourceModel */
        $dataSourceModel = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', LanguageDataSource::class);

        $this->modelValidator->validate($dataSourceModel);

        $this->languageDataSourceService->createIfNotExists($dataSourceModel);
    }
}