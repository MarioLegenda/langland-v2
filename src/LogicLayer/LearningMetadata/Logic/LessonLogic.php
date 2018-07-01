<?php

namespace App\LogicLayer\LearningMetadata\Logic;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\DataSourceGateway\Gateway\LessonGateway;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Lesson;
use App\LogicLayer\LogicInterface;
use App\LogicLayer\LearningMetadata\Model\Lesson as LessonPropagationModel;

class LessonLogic implements LogicInterface
{
    /**
     * @var LessonGateway $lessonGateway
     */
    private $lessonGateway;
    /**
     * LessonLogic constructor.
     * @param LessonGateway $lessonGateway
     */
    public function __construct(
        LessonGateway $lessonGateway
    ) {
        $this->lessonGateway = $lessonGateway;
    }
    /**
     * @param DomainModelInterface $domainModel
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): LayerPropagationResourceResponse
    {
        $newLesson = $this->lessonGateway->create($domainModel);

        return new LessonPropagationModel($newLesson);
    }
}