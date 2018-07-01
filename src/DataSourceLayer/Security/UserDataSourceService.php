<?php

namespace App\DataSourceLayer\Security;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Security\Doctrine\Entity\User;
use App\DataSourceLayer\Infrastructure\Security\Repository\UserRepository;

class UserDataSourceService
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;
    /**
     * UserDataSourceService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }
    /**
     * @param DataSourceEntity|User $dataSourceEntity
     * @return DataSourceEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DataSourceEntity $dataSourceEntity): DataSourceEntity
    {
        return $this->userRepository->persistAndFlush($dataSourceEntity);
    }
}