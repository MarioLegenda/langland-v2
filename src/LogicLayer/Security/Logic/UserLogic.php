<?php

namespace App\LogicLayer\Security\Logic;

use App\DataSourceGateway\Gateway\UserGateway;
use App\Infrastructure\Response\LayerPropagationResourceResponse;
use App\LogicLayer\DomainModelInterface;
use App\LogicLayer\Security\Domain\User as UserDomainModel;
use App\LogicLayer\Security\Model\User as UserModel;

class UserLogic
{
    /**
     * @var UserGateway $userGateway
     */
    private $userGateway;
    /**
     * UserLogic constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(
        UserGateway $userGateway
    ) {
        $this->userGateway = $userGateway;
    }
    /**
     * @param DomainModelInterface|UserDomainModel $domainModel
     * @return LayerPropagationResourceResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): LayerPropagationResourceResponse
    {
        /** @var DomainModelInterface|UserDomainModel $createdUser */
        $createdUser = $this->userGateway->create($domainModel);

        return new UserModel($createdUser);
    }
}