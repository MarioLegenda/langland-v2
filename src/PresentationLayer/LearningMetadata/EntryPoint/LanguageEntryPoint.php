<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\Infrastructure\Response\LayerPropagationResponse;
use App\LogicGateway\Gateway\LanguageGateway;
use App\PresentationLayer\Model\Language as LanguageModel;
use App\PresentationLayer\Model\PresentationModelInterface;
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
        /** @var LayerPropagationResponse $createdLanguage */
        $createdLanguage = $this->languageGateway->create($language);

        return $this->apiResponseWrapper->createLanguageCreate($createdLanguage->toArray());
    }
}