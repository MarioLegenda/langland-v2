<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\LogicGateway\Gateway\WordGateway;
use App\PresentationLayer\Model\Word\Word;
use App\Symfony\ApiResponseWrapper;
use Symfony\Component\HttpFoundation\Response;

class WordEntryPoint
{
    /**
     * @var WordGateway
     */
    private $wordGateway;
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * WordEntryPoint constructor.
     * @param WordGateway $wordGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        WordGateway $wordGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->wordGateway = $wordGateway;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param Word $word
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Word $word): Response
    {
        $layerPropagationModel = $this->wordGateway->create($word);
    }
}