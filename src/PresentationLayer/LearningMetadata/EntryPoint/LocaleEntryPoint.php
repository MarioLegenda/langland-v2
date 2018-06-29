<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicGateway\Gateway\LocaleGateway;
use App\PresentationLayer\Infrastructure\Model\Locale;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class LocaleEntryPoint
{
    /**
     * @var LocaleGateway $localeGateway
     */
    private $localeGateway;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * CategoryEntryPoint constructor.
     * @param LocaleGateway $localeGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        LocaleGateway $localeGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->localeGateway = $localeGateway;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param Locale $locale
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Locale $locale): Response
    {
        /** @var LayerPropagationResourceResponse $localePropagationModel */
        $localePropagationModel = $this->localeGateway->create($locale);

        return $this->apiResponseWrapper->createLessonCreate($localePropagationModel->toArray());
    }
}