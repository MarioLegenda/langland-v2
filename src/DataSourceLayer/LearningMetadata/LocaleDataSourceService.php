<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LocaleRepository;

class LocaleDataSourceService
{
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * LocaleDataSourceService constructor.
     * @param LocaleRepository $localeRepository
     */
    public function __construct(
        LocaleRepository $localeRepository
    ) {
        $this->localeRepository = $localeRepository;
    }
    /**
     * @param DataSourceEntity|Locale $dataSourceEntity
     * @return Locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DataSourceEntity $dataSourceEntity): Locale
    {
        /** @var Locale $existingLocale */
        $existingLocale = $this->localeRepository->findOneBy([
            'name' => $dataSourceEntity->getName(),
        ]);

        if ($existingLocale instanceof Locale) {
            $message = sprintf(
                'Locale \'%s\' already exists',
                $dataSourceEntity->getName()
            );

            throw new \RuntimeException($message);
        }

        return $this->localeRepository->persistAndFlush($dataSourceEntity);
    }
}