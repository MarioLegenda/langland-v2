<?php

namespace App\Web\LearningMetadata;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\Symfony\ApiResponseWrapper;
use Library\Http\Request\Contract\PaginatedRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class LocaleController
{
    /**
     * @var LocaleEntryPoint $localeEntryPoint
     */
    private $localeEntryPoint;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * LocaleController constructor.
     * @param LocaleEntryPoint $localeEntryPoint
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        LocaleEntryPoint $localeEntryPoint,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->localeEntryPoint = $localeEntryPoint;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param PaginatedRequestInterface $paginatedRequest
     * @return Response
     */
    public function getAll(PaginatedRequestInterface $paginatedRequest): Response
    {
        /** @var LayerPropagationCollectionResponse $layerPropagationCollectionResponse */
        $layerPropagationCollectionResponse = $this->localeEntryPoint->getAll($paginatedRequest);

        return $this->apiResponseWrapper->createGetAllLocales($layerPropagationCollectionResponse->toArray());
    }
}