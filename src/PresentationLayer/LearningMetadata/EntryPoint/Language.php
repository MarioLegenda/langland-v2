<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\LanguageGateway;
use App\PresentationLayer\Model\Language as LanguageModel;
use App\PresentationLayer\Model\PresentationModelInterface;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class Language
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
     * Language constructor.
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
    public function create(LanguageModel $language): Response
    {
        $this->languageGateway->create($language);

        return $this->apiResponseWrapper->createLanguageCreate();
    }
}