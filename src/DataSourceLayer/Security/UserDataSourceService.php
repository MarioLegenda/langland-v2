<?php

namespace App\DataSourceLayer\Security;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use App\DataSourceLayer\Infrastructure\Security\Doctrine\Entity\User;
use App\DataSourceLayer\Infrastructure\Security\Repository\UserRepository;

class UserDataSourceService
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * UserDataSourceService constructor.
     * @param UserRepository $userRepository
     * @param LocaleRepository $localeRepository
     */
    public function __construct(
        UserRepository $userRepository,
        LocaleRepository $localeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->localeRepository = $localeRepository;
    }
    /**
     * @param DataSourceEntity|User $dataSourceEntity
     * @return DataSourceEntity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DataSourceEntity $dataSourceEntity): DataSourceEntity
    {
        $locale = $this->getLocale($dataSourceEntity->getLocale());

        $dataSourceEntity->setLocale($locale);

        return $this->userRepository->persistAndFlush($dataSourceEntity);
    }

    /**
     * @param DataSourceEntity|Locale $locale
     * @return Locale
     */
    private function getLocale(DataSourceEntity $locale): Locale
    {
        $dbLocale = $this->localeRepository->findOneBy([
            'name' => $locale->getName(),
        ]);

        if (!$dbLocale instanceof Locale) {
            $message = sprintf(
                'Locale not found for user creation'
            );

            throw new \RuntimeException($message);
        }

        return $dbLocale;
    }
}