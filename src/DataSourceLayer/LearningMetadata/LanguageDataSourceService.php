<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSource;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
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
     * Language constructor.
     * @param LanguageRepository $languageRepository
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        LanguageRepository $languageRepository,
        ModelValidator $modelValidator
    ) {
        $this->languageRepository = $languageRepository;
        $this->modelValidator = $modelValidator;
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

        return $this->languageRepository->persistAndFlush($language);
    }
}