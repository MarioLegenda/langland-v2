<?php

namespace App\LogicLayer\LearningMetadata\Model;

use App\LogicLayer\LearningMetadata\Domain\Lesson as LessonDomainModel;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
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
        return [
            'id' => $this->lesson->getId(),
            'name' => $this->lesson->getName(),
            'temporaryText' => $this->lesson->getTemporaryText(),
            'createdAt' => Util::formatFromDate($this->lesson->getCreatedAt()),
            'updatedAt' => Util::formatFromDate($this->lesson->getUpdatedAt()),
        ];
    }
    /**
     * @return object|LessonDomainModel
     */
    public function getPropagationObject(): object
    {
        return $this->lesson;
    }
}