<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;

class LanguageDataSourceService
{
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * Language constructor.
     * @param LanguageRepository $languageRepository
     * @param LocaleRepository $localeRepository
     */
    public function __construct(
        LanguageRepository $languageRepository,
        LocaleRepository $localeRepository
    ) {
        $this->languageRepository = $languageRepository;
        $this->localeRepository = $localeRepository;
    }
    /**
     * @param DataSourceEntity|Language $language
     * @return LanguageDataSource
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createIfNotExists(DataSourceEntity $language): LanguageDataSource
    {
        /** @var LanguageDataSource $existingLanguage */
        $existingLanguage = $this->languageRepository->findOneBy([
            'name' => $language->getName(),
        ]);

        if ($existingLanguage instanceof DataSourceEntity) {
            $message = sprintf(
                'Language with name \'%s\' already exists',
                $existingLanguage->getName()
            );

            throw new \RuntimeException($message);
        }

        $locale = $this->localeRepository->findOneBy([
            'name' => $language->getLocale(),
        ]);

        if (!$locale instanceof Locale) {
            $message = sprintf(
                'Locale \'%s\' does not exist',
                $language->getLocale()
            );

            throw new \RuntimeException($message);
        }

        return $this->languageRepository->persistAndFlush($language);
    }
    /**
     * @param PaginatedInternalizedRequestInterface $paginatedInternalizedRequest
     * @return iterable|DataSourceEntity[]
     */
    public function getLanguages(PaginatedInternalizedRequestInterface $paginatedInternalizedRequest): iterable
    {
        $languages = $this->languageRepository->findBy([
                'locale' => $paginatedInternalizedRequest->getLocale(),
            ],
            null,
            $paginatedInternalizedRequest->getLimit(),
            $paginatedInternalizedRequest->getOffset()
        );

        return $languages;
    }
}