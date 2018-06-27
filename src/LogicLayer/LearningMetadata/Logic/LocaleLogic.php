<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\DataSourceGateway\Gateway\LocaleGateway;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Locale;
use App\LogicLayer\LearningMetadata\Model\Locale as LocalePresentationResourceModel;

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
}