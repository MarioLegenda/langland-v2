<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\LearningMetadata\LessonDataSourceService;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\LearningMetadata\Domain\Lesson as LessonDomainModel;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson as LessonDataSource;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class LessonGateway
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var LessonDataSourceService $lessonDataSourceService
     */
    private $lessonDataSourceService;
    /**
     * LessonGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param LessonDataSourceService $lessonDataSourceService
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        LessonDataSourceService $lessonDataSourceService
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->lessonDataSourceService = $lessonDataSourceService;
    }
    /**
     * @param DomainModelInterface|LessonDomainModel $domainModel
     * @return DomainModelInterface|LessonDomainModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        /** @var LessonDataSource $lessonDataSource */
        $lessonDataSource = $this->serializerWrapper
            ->convertFromToByGroup($domainModel, 'default', LessonDataSource::class);

        $this->modelValidator->validate($lessonDataSource);

        /** @var LessonDataSource $newLesson */
        $newLesson = $this->lessonDataSourceService->create($lessonDataSource);

        /** @var LessonDomainModel $domainLesson */
        $domainLesson = $this->serializerWrapper
            ->convertFromToByGroup($newLesson, 'default', LessonDomainModel::class);

        return $domainLesson;
    }
}