<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LocaleRepository;
use App\Library\Http\Request\Contract\PaginatedInternalizedRequestInterface;
use App\Library\Http\Request\Contract\PaginatedRequestInterface;
use Library\Infrastructure\Helper\ModelValidator;

class LanguageDataSourceService
{
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * Language constructor.
     * @param LanguageRepository $languageRepository
     * @param LocaleRepository $localeRepository
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        LanguageRepository $languageRepository,
        LocaleRepository $localeRepository,
        ModelValidator $modelValidator
    ) {
        $this->languageRepository = $languageRepository;
        $this->modelValidator = $modelValidator;
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