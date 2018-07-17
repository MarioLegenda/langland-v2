<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\Infrastructure\Response\LayerPropagationCollectionResponse;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\LogicGateway\Gateway\LanguageGateway;
use App\PresentationLayer\Infrastructure\Model\Language as LanguageModel;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LanguageEntryPoint
 * @package App\PresentationLayer\LearningMetadata\EntryPoint
 */
class LanguageEntryPoint
{
    /**
     * @var LanguageGateway $languageGateway
     */
    private $languageGateway;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * LanguageEntryPoint constructor.
     * @param LanguageGateway $languageGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        LanguageGateway $languageGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->languageGateway = $languageGateway;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param LanguageModel $language
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(LanguageModel $language): Response
    {
        /** @var LayerPropagationResourceResponse $createdLanguage */
        $createdLanguage = $this->languageGateway->create($language);

        return $this->apiResponseWrapper->createLanguageCreate($createdLanguage->toArray());
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return LayerPropagationCollectionResponse
     */
    public function getLanguages(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): LayerPropagationCollectionResponse
    {
        /** @var LayerPropagationResourceResponse $languageCollection */
        $layerPropagationResourceResponse = $this->languageGateway->getLanguages($paginatedInternalizedRequest);

        return $layerPropagationResourceResponse;
    }
}