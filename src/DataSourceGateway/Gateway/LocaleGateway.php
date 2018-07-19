<?php

namespace App\DataSourceGateway\Gateway;

use App\LogicLayer\LearningMetadata\Domain\Locale as LocaleDomainModel;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale as LocaleDataSourceModel;
use App\DataSourceLayer\LearningMetadata\LocaleDataSourceService;
use App\LogicLayer\DomainModelInterface;
use Library\Http\Request\Contract\PaginatedRequestInterface;
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
     * @param DomainModelInterface|LocaleDomainModel $domainModel
     * @return DomainModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        $this->modelValidator->validate($domainModel);

        $this->checkExistingDefaultLocale($domainModel);

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

    /**
     * @param PaginatedRequestInterface $paginatedRequest
     * @return DomainModelInterface|LocaleDomainModel|iterable
     */
    public function getAll(PaginatedRequestInterface $paginatedRequest): iterable
    {
        $locales = $this->localeDataSourceService->getAll($paginatedRequest);

        $this->modelValidator->bulkValidate($locales);

        /** @var DomainModelInterface[]|LocaleDomainModel[]|iterable $domainModels */
        $domainModels = $this->serializerWrapper->convertCollectionByGroup(
            $locales,
            'default',
            LocaleDomainModel::class
        );

        return $domainModels;
    }
    /**
     * @param DomainModelInterface|LocaleDomainModel $domainModel
     */
    private function checkExistingDefaultLocale(DomainModelInterface $domainModel)
    {
        if ($domainModel->isDefault() === true) {
            $existingLocale = $this->localeDataSourceService->getDefaultLocale();

            if ($existingLocale instanceof LocaleDataSourceModel) {
                $message = sprintf(
                    'Default locale already exists. There can only be one default locale in the system. Locale selected: \'%s\'',
                    $domainModel->getName()
                );

                throw new \RuntimeException($message);
            }
        }
    }
}