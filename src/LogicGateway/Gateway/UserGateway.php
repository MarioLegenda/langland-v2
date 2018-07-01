<?php

namespace App\LogicGateway\Gateway;

use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\Security\Logic\UserLogic;
use App\PresentationLayer\Infrastructure\Model\PresentationModelInterface;
use App\PresentationLayer\Infrastructure\Model\User;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\LogicLayer\Security\Domain\User as UserDomainModel;

class UserGateway
{
    /**
     * @var SerializerWrapper $serializationWrapper
     */
    private $serializationWrapper;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var UserLogic $userLogic
     */
    private $userLogic;
    /**
     * UserGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param UserLogic $userLogic
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        UserLogic $userLogic
    ) {
        $this->serializationWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->userLogic = $userLogic;
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

        /** @var DomainModelInterface|UserDomainModel $userDomainModel */
        $userDomainModel = $this->serializationWrapper->convertFromToByGroup(
            $presentationModel,
            'default',
            UserDomainModel::class
        );

        return $this->userLogic->create($userDomainModel);
    }
}