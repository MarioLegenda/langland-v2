<?php

namespace App\Tests\Command;

use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\Infrastructure\Model\Category;
use App\PresentationLayer\Infrastructure\Model\Language;
use App\PresentationLayer\Infrastructure\Model\Lesson;
use App\PresentationLayer\Infrastructure\Model\Locale;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use App\Symfony\Command\BaseCommand;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedLanguageData extends BaseCommand
{
    /**
     * @var LanguageEntryPoint $languageEntryPoint
     */
    private $languageEntryPoint;
    /**
     * @var CategoryEntryPoint $categoryEntryPoint
     */
    private $categoryEntryPoint;
    /**
     * @var LocaleEntryPoint $localeEntryPoint
     */
    private $localeEntryPoint;
    /**
     * @var LessonEntryPoint $lessonEntryPoint
     */
    private $lessonEntryPoint;
    /**
     * @var PresentationModelDataProvider $presentationModelDataProvider
     */
    private $presentationModelDataProvider;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var EntityManagerInterface $em
     */
    private $em;
    /**
     * SeedCommand constructor.
     * @param LanguageEntryPoint $languageEntryPoint
     * @param CategoryEntryPoint $categoryEntryPoint
     * @param LocaleEntryPoint $localeEntryPoint
     * @param LessonEntryPoint $lessonEntryPoint
     * @param PresentationModelDataProvider $presentationModelDataProvider
     * @param SerializerWrapper $serializerWrapper
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        LanguageEntryPoint $languageEntryPoint,
        CategoryEntryPoint $categoryEntryPoint,
        LocaleEntryPoint $localeEntryPoint,
        LessonEntryPoint $lessonEntryPoint,
        PresentationModelDataProvider $presentationModelDataProvider,
        SerializerWrapper $serializerWrapper,
        EntityManagerInterface $entityManager
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
        $this->categoryEntryPoint = $categoryEntryPoint;
        $this->localeEntryPoint = $localeEntryPoint;
        $this->lessonEntryPoint = $lessonEntryPoint;
        $this->presentationModelDataProvider = $presentationModelDataProvider;
        $this->serializerWrapper = $serializerWrapper;
        $this->em = $entityManager;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:seed-language-data');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $progress = new ProgressBar($this->output);
        $progress->setMaxSteps(70);
        $progress->setFormat('%current%/%max% %percent:3s%% %elapsed:6s% %memory:6s%');

        $progress->start();

        $progress->advance();

        /** @var Locale $locale */
        $locale = $this->createLocale();

        $progress->advance();

        $categories = new CollectionEntity();
        for ($i = 0; $i < 5; $i++) {
            $category = $this->createCategory($locale);

            $categoryMetadata = new CollectionMetadata(
                $category->getId(),
                ActionType::fromValue('create')
            );

            $categories->addMetadata($categoryMetadata);

            $progress->advance();
        }

        $languages = [];
        for ($i = 0; $i < 3; $i++) {
            /** @var Language $language */
            $language = $this->createLanguage($locale);

            $languages[] = $language;

            $progress->advance();
        }

        $lessons = [];
        /** @var Language $language */
        foreach ($languages as $language) {
            for ($l = 0; $l < 20; $l++) {
                $lesson = $this->createLesson($language, $locale);

                $lessons[] = $lesson;

                $progress->advance();
            }
        }

        $progress->finish();
    }
    /**
     * @param array|null $locale
     * @return Locale
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLocale(array $locale = null): Locale
    {
        if (empty($locale)) {
            $locale = [
                'name' => 'en',
                'default' => true,
            ];
        }

        $locale = $this->presentationModelDataProvider->getLocaleModel($locale);

        $response = $this->localeEntryPoint->create($locale);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        /** @var Locale $createdLocale */
        $createdLocale = $this->serializerWrapper->deserialize($responseData, Locale::class);

        return $createdLocale;
    }
    /**
     * @param Locale $locale
     * @return Language
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguage(Locale $locale): Language
    {
        /** @var Language $languageModel */
        $languageModel = $this->presentationModelDataProvider->getLanguageModel(
            $this->presentationModelDataProvider->getImageModel(),
            $locale
        );

        $response = $this->languageEntryPoint->create($languageModel);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        /** @var Language $language */
        $language = $this->serializerWrapper->deserialize($responseData, Language::class);

        return $language;
    }
    /**
     * @param Locale $locale
     * @return Category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createCategory(Locale $locale): Category
    {
        /** @var Category $categoryModel */
        $categoryModel = $this->presentationModelDataProvider->getCategoryModel($locale);

        $response = $this->categoryEntryPoint->create($categoryModel);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];

        /** @var Category $category */
        $category = $this->serializerWrapper->deserialize($responseData, Category::class);

        return $category;
    }
    /**
     * @param Language $language
     * @param Locale $locale
     * @return Lesson
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLesson(Language $language, Locale $locale): Lesson
    {
        $lessonModel = $this->presentationModelDataProvider->getLessonModel($language, $locale);

        $response = $this->lessonEntryPoint->create($lessonModel);

        $responseData = json_decode($response->getContent(), true)['resource']['data'];
        $responseData['lessonData'] = $this->makeLessonDataSeriazible($responseData['lessonData']);

        /** @var Lesson $lesson */
        $lesson = $this->serializerWrapper->deserialize($responseData, Lesson::class);

        return $lesson;
    }
    /**
     * @param array $lessonData
     * @return array
     */
    private function makeLessonDataSeriazible(array $lessonData): array
    {
        $seriazibleLessonData = [];
        foreach ($lessonData as $item) {
            $seriazibleLessonData[]['name'] = $item;
        }

        return $seriazibleLessonData;
    }
}