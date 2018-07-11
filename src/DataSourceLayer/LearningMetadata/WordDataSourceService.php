<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LessonRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\WordRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Word as WordDataSource;

class WordDataSourceService
{
    /**
     * @var WordRepository $wordRepository
     */
    private $wordRepository;
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var LessonRepository $lessonRepository
     */
    private $lessonRepository;
    /**
     * WordDataSourceService constructor.
     * @param WordRepository $wordRepository
     * @param LanguageRepository $languageRepository
     * @param LessonRepository $lessonRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        LanguageRepository $languageRepository,
        LessonRepository $lessonRepository
    ) {
        $this->wordRepository = $wordRepository;
        $this->languageRepository = $languageRepository;
        $this->lessonRepository = $lessonRepository;
    }
    /**
     * @param DataSourceEntity|WordDataSource $wordDataSourceEntity
     * @return WordDataSource
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(DataSourceEntity $wordDataSourceEntity): Word
    {
        $this->connectToLanguage($wordDataSourceEntity);
        $this->connectToLesson($wordDataSourceEntity);

        return $this->wordRepository->persistAndFlush($wordDataSourceEntity);
    }
    /**
     * @param DataSourceEntity|Word $wordDataSourceEntity
     */
    private function connectToLesson(DataSourceEntity $wordDataSourceEntity): void
    {
        if (!$wordDataSourceEntity->getLesson() instanceof Lesson) {
            return;
        }

        $language = $wordDataSourceEntity->getLanguage();

        /** @var Lesson|null $lesson */
        $lesson = $this->lessonRepository->findOneBy([
            'language' => $language,
            'internalName' => $wordDataSourceEntity->getLesson()->getInternalName(),
        ]);

        if (!$lesson instanceof Lesson) {
            $message = sprintf(
                'Word cannot be created. Lesson with name \'%s\' cannot be found',
                $wordDataSourceEntity->getLesson()->getName()
            );

            throw new \RuntimeException($message);
        }

        $wordDataSourceEntity->setLesson($lesson);
    }
    /**
     * @param DataSourceEntity|WordDataSource $wordDataSourceEntity
     */
    private function connectToLanguage(DataSourceEntity $wordDataSourceEntity)
    {
        /** @var Language $language */
        $language = $this->languageRepository->findOneBy([
            'name' => $wordDataSourceEntity->getLanguage()->getName(),
        ]);

        if (!$language instanceof Language) {
            $message = sprintf(
                'Language with name \'%s\' does not exist',
                $language->getName()
            );

            throw new \RuntimeException($message);
        }

        $wordDataSourceEntity->setLanguage($language);
    }
}