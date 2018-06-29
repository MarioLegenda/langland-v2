<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\LearningMetadata\Logic\LessonLogic;
use App\PresentationLayer\Infrastructure\Model\Lesson;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\LearningMetadata\Domain\Lesson as LessonDomainModel;

class LessonGateway
{
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LessonLogic $lessonLogic
     */
    private $lessonLogic;
    /**
     * LessonGateway constructor.
     * @param LessonLogic $lessonLogic
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        LessonLogic $lessonLogic,
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator
    ) {
        $this->modelValidator = $modelValidator;
        $this->serializerWrapper = $serializerWrapper;
        $this->lessonLogic = $lessonLogic;
    }
    /**
     * @param PresentationModelInterface $presentationModel
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(PresentationModelInterface $presentationModel): LayerPropagationResourceResponse
    {
        $this->modelValidator->validate($presentationModel);

        /** @var LessonDomainModel $domainModel */
        $domainModel = $this->serializerWrapper
            ->convertFromToByGroup($presentationModel, 'default', LessonDomainModel::class);

        $this->modelValidator->validate($domainModel);

        /** @var LayerPropagationResourceResponse $layerPropagationResponse */
        $layerPropagationResponse = $this->lessonLogic->create($domainModel);

        return $layerPropagationResponse;
    }
}