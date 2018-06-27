<?php

namespace App\DataSourceGateway\Gateway;

use App\LogicLayer\LearningMetadata\Domain\Locale as LocaleDomainModel;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Locale as LocaleDataSourceModel;
use App\DataSourceLayer\LearningMetadata\LocaleDataSourceService;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class LocaleGateway
{
    /**
     * @var LocaleDataSourceService $localeDataSourceService
     */
    private $localeDataSourceService;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * LocaleGateway constructor.
     * @param LocaleDataSourceService $localeDataSourceService
     * @param ModelValidator $modelValidator
     * @param SerializerWrapper $serializerWrapper
     */
    public function __construct(
        LocaleDataSourceService $localeDataSourceService,
        ModelValidator $modelValidator,
        SerializerWrapper $serializerWrapper
    ) {
        $this->localeDataSourceService = $localeDataSourceService;
        $this->modelValidator = $modelValidator;
        $this->serializerWrapper = $serializerWrapper;
    }
    /**
     * @param DomainModelInterface $domainModel
     * @return DomainModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        $this->modelValidator->validate($domainModel);

        /** @var LocaleDataSourceModel $localeDataSourceEntity */
        $localeDataSourceEntity = $this->serializerWrapper->convertFromToByGroup(
            $domainModel,
            'default',
            LocaleDataSourceModel::class
        );

        $this->modelValidator->validate($localeDataSourceEntity);

        /** @var LocaleDataSourceModel $newLocale */
        $newLocale = $this->localeDataSourceService->create($localeDataSourceEntity);
        /** @var LocaleDomainModel|DomainModelInterface $domainLocale */
        $domainLocale = $this->serializerWrapper->convertFromToByGroup(
            $newLocale,
            'default',
            LocaleDomainModel::class
        );

        return $domainLocale;
    }
}