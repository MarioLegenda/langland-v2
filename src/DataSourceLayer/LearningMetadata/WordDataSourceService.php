<?php

namespace App\DataSourceLayer\LearningMetadata;

use App\DataSourceLayer\Infrastructure\DataSourceEntity;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Word\Word;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
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
     * WordDataSourceService constructor.
     * @param WordRepository $wordRepository
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        WordRepository $wordRepository,
        LanguageRepository $languageRepository
    ) {
        $this->wordRepository = $wordRepository;
        $this->languageRepository = $languageRepository;
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

        return $this->wordRepository->persistAndFlush($wordDataSourceEntity);
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