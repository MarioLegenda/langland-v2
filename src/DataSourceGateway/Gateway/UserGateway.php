<?php

namespace App\DataSourceGateway\Gateway;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Security\Doctrine\Entity\User as UserDataSource;
use App\LogicLayer\Security\Domain\User as UserDomainModel;
use App\DataSourceLayer\Security\UserDataSourceService;
use App\LogicLayer\DomainModelInterface;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;

class UserGateway
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
     * @var UserDataSourceService $userDataSourceService
     */
    private $userDataSourceService;
    /**
     * UserGateway constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param ModelValidator $modelValidator
     * @param UserDataSourceService $userDataSourceService
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        ModelValidator $modelValidator,
        UserDataSourceService $userDataSourceService
    ) {
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->userDataSourceService = $userDataSourceService;
    }
    /**
     * @param DomainModelInterface $domainModel
     * @return DomainModelInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DomainModelInterface $domainModel): DomainModelInterface
    {
        $this->modelValidator->validate($domainModel);

        /** @var UserDataSource $userDataSource */
        $userDataSource = $this->serializerWrapper->convertFromToByGroup(
            $domainModel,
            'default',
            UserDataSource::class
        );

        $this->modelValidator->validate($userDataSource);

        $createdDataSourceModel = $this->userDataSourceService->create($userDataSource);

        /** @var UserDomainModel $createdDomainModel */
        $createdDomainModel = $this->serializerWrapper->convertFromToByGroup(
            $createdDataSourceModel,
            'default',
            UserDomainModel::class
        );

        return $createdDomainModel;
    }
}