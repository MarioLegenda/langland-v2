<?php

namespace App\PresentationLayer\LearningMetadata\EntryPoint;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicGateway\Gateway\LessonGateway;
use App\Symfony\ApiResponseWrapper;
use App\PresentationLayer\Infrastructure\Model\Lesson as LessonPresentationModel;
use Symfony\Component\HttpFoundation\Response;

class LessonEntryPoint
{
    /**
     * @var ApiResponseWrapper $apiResponseWrapper
     */
    private $apiResponseWrapper;
    /**
     * @var LessonGateway $lessonGateway
     */
    private $lessonGateway;
    /**
     * LessonEntryPoint constructor.
     * @param LessonGateway $lessonGateway
     * @param ApiResponseWrapper $apiResponseWrapper
     */
    public function __construct(
        LessonGateway $lessonGateway,
        ApiResponseWrapper $apiResponseWrapper
    ) {
        $this->lessonGateway = $lessonGateway;
        $this->apiResponseWrapper = $apiResponseWrapper;
    }
    /**
     * @param LessonPresentationModel $model
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(LessonPresentationModel $model): Response
    {
        /** @var LayerPropagationResourceResponse $lessonPropagationModel */
        $lessonPropagationModel = $this->lessonGateway->create($model);

        return $this->apiResponseWrapper->createLessonCreate($lessonPropagationModel->toArray());
    }
}