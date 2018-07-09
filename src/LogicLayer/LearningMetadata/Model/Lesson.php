<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\LogicLayer\LearningMetadata\Domain\Lesson as LessonDomainModel;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Domain\LessonData;
use Library\Util\Util;

class Lesson implements LayerPropagationResourceResponse
{
    /**
     * @var LessonDomainModel $lesson
     */
    private $lesson;
    /**
     * Lesson constructor.
     * @param LessonDomainModel $lesson
     */
    public function __construct(
        LessonDomainModel $lesson
    ) {
        $this->lesson = $lesson;
    }
    /**
     * @inheritdoc
     */
    public function toArray(): iterable
    {
        return $this->lesson->toArray();
    }
    /**
     * @return object|LessonDomainModel
     */
    public function getPropagationObject(): object
    {
        return $this->lesson;
    }
}