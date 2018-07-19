<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\LocaleGateway;
use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Locale;
use App\LogicLayer\LearningMetadata\Model\Locale as LocalePresentationResourceModel;
use App\LogicLayer\LearningMetadata\Model\LocaleCollection;
use Library\Http\Request\Contract\PaginatedRequestInterface;
use App\LogicLayer\LearningMetadata\Model\Locale as LocaleModel;

class LocaleLogic
{
    /**
     * @var LocaleGateway $localeGateway
     */
    private $localeGateway;
    /**
     * LocaleLogic constructor.
     * @param LocaleGateway $localeGateway
     */
    public function __construct(
        LocaleGateway $localeGateway
    ) {
        $this->localeGateway = $localeGateway;
    }
    /**
     * @param DomainModelInterface $locale
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $locale): LayerPropagationResourceResponse
    {
        /** @var Locale|DomainModelInterface $createdLocale */
        $createdLocale = $this->localeGateway->create($locale);

        return new LocalePresentationResourceModel($createdLocale);
    }
    /**
     * @param PaginatedRequestInterface $paginatedRequest
     * @return LayerPropagationCollectionResponse
     */
    public function getAll(PaginatedRequestInterface $paginatedRequest): LayerPropagationCollectionResponse
    {
        /** @var DomainModelInterface[]|Locale[]|iterable $languages */
        $locales = $this->localeGateway->getAll($paginatedRequest);

        $localeModels = [];
        /** @var DomainModelInterface|Locale $language */
        foreach ($locales as $locale) {
            $localeModels[] = new LocaleModel($locale);
        }

        return new LocaleCollection(
            $localeModels,
            true
        );
    }
}