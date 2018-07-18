<?php

namespace App\Web\LearningMetadata;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\PresentationLayer\Infrastructure\Model\Language;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class LanguageController
{
    /**
     * @var LanguageEntryPoint $languageEntryPoint
     */
    private $languageEntryPoint;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * LanguageController constructor.
     * @param LanguageEntryPoint $languageEntryPoint
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        LanguageEntryPoint $languageEntryPoint,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param Language $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * Not yet ready for production
     */
    public function create(Language $user)
    {
        $this->languageEntryPoint->create($user);
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return Response
     */
    public function getAll(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): Response
    {
        /** @var LayerPropagationCollectionResponse $layerPropagationCollection */
        $layerPropagationCollection = $this->languageEntryPoint->getLanguages($paginatedInternalizedRequest);

        return $this->apiResponseWrapper->createGetAllLanguages($layerPropagationCollection->toArray());
    }
}