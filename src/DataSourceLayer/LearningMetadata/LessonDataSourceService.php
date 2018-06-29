<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LessonRepository;
use Library\Infrastructure\Helper\ModelValidator;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson as LessonDataSource;

class LessonDataSourceService
{
    /**
     * @var LessonRepository $lessonRepository
     */
    private $lessonRepository;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * LessonDataSourceService constructor.
     * @param ModelValidator $modelValidator
     * @param LanguageRepository $languageRepository
     * @param LessonRepository $lessonRepository
     */
    public function __construct(
        LessonRepository $lessonRepository,
        LanguageRepository $languageRepository,
        ModelValidator $modelValidator
    ) {
        $this->lessonRepository = $lessonRepository;
        $this->modelValidator = $modelValidator;
        $this->languageRepository = $languageRepository;
    }
    /**
     * @param DataSourceEntity|LessonDataSource $dataSourceEntity
     * @return LessonDataSource
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DataSourceEntity $dataSourceEntity): LessonDataSource
    {
        $dataSourceEntity->setLanguage($this->getLanguage($dataSourceEntity));

        return $this->lessonRepository->persistAndFlush($dataSourceEntity);
    }
    /**
     * @param DataSourceEntity|LessonDataSource $dataSourceEntity
     * @return Language
     */
    private function getLanguage(DataSourceEntity $dataSourceEntity): Language
    {
        $language = $dataSourceEntity->getLanguage();

        $dbLanguage = $this->languageRepository->findOneBy([
            'id' => $language->getId(),
        ]);

        if (!$dbLanguage instanceof Language) {
            $message = sprintf(
                'Language with id %d not found',
                $language->getId()
            );

            throw new \RuntimeException($message);
        }

        return $dbLanguage;
    }
}