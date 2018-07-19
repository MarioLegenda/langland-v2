<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use Library\Http\Request\Contract\PaginatedRequestInterface;

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

    /**
     * @param PaginatedRequestInterface $paginatedRequest
     * @return iterable
     */
    public function getAll(PaginatedRequestInterface $paginatedRequest): iterable
    {
        $locales = $this->localeRepository->findBy(
            [],
            null,
            $paginatedRequest->getLimit(),
            $paginatedRequest->getOffset()
        );

        return $locales;
    }
    /**
     * @return Locale
     */
    public function getDefaultLocale(): ?Locale
    {
        /** @var Locale $potentialLocale */
        $potentialLocale = $this->localeRepository->findOneBy([
            'default' => true,
        ]);

        return $potentialLocale;
    }
}