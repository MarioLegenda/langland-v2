<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

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
     * @param LanguageModel|PresentationModelInterface $language
     * @return Response
     */
    public function put(LanguageModel $language): Response
    {
        $this->languageGateway->create($language);

        return $this->apiResponseWrapper->createLanguageCreate();
    }
}