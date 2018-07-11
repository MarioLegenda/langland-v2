<?php

namespace App\Tests\Command;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Lesson;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\CategoryRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LessonRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\Infrastructure\Model\Lesson as LessonPresentationModel;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\Symfony\Command\BaseCommand;
use App\Tests\PresentationLayer\DataProvider\PresentationModelDataProvider;
use Doctrine\ORM\EntityManagerInterface;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Infrastructure\Model\Category;
use App\PresentationLayer\Infrastructure\Model\Locale as LocalePresentationModel;
use App\PresentationLayer\Infrastructure\Model\Language as LanguagePresentationModel;

class SeedWordData extends BaseCommand
{
    /**
     * @var WordEntryPoint $wordEntryPoint
     */
    private $wordEntryPoint;
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * @var LessonRepository $lessonRepository
     */
    private $lessonRepository;
    /**
     * @var PresentationModelDataProvider $presentationModelDataProvider
     */
    private $presentationModelDataProvider;
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;
    /**
     * @var EntityManagerInterface $em
     */
    private $em;
    /**
     * SeedWordData constructor.
     * @param WordEntryPoint $wordEntryPoint
     * @param CategoryRepository $categoryRepository
     * @param LanguageRepository $languageRepository
     * @param LocaleRepository $localeRepository
     * @param LessonRepository $lessonRepository
     * @param PresentationModelDataProvider $presentationModelDataProvider
     * @param SerializerWrapper $serializerWrapper
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        WordEntryPoint $wordEntryPoint,
        CategoryRepository $categoryRepository,
        LanguageRepository $languageRepository,
        LocaleRepository $localeRepository,
        LessonRepository $lessonRepository,
        PresentationModelDataProvider $presentationModelDataProvider,
        SerializerWrapper $serializerWrapper,
        EntityManagerInterface $entityManager
    ) {
        $this->wordEntryPoint = $wordEntryPoint;
        $this->languageRepository = $languageRepository;
        $this->localeRepository = $localeRepository;
        $this->lessonRepository = $lessonRepository;
        $this->presentationModelDataProvider = $presentationModelDataProvider;
        $this->serializerWrapper = $serializerWrapper;
        $this->categoryRepository = $categoryRepository;
        $this->em = $entityManager;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:seed-word-data');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $progress = new ProgressBar($this->output);
        $progress->setMaxSteps(773);
        $progress->setFormat('%current%/%max% %percent:3s%% %elapsed:6s% %memory:6s%');

        $progress->start();

        $languages = $this->languageRepository->findAll();

        $dbCategories = $this->categoryRepository->findAll();

        $categories = new CollectionEntity();
        foreach ($dbCategories as $dbCategory) {
            $category = $this->serializerWrapper->convertFromToByGroup(
                $dbCategory,
                'default',
                Category::class
            );

            $categoryMetadata = new CollectionMetadata(
                $category->getId(),
                ActionType::fromValue('create')
            );

            $categories->addMetadata($categoryMetadata);

            $progress->advance();
        }

        $levels = [0, 1, 2, 3, 4];

        foreach ($languages as $language) {
            /** @var LanguagePresentationModel $languagePresentationModel */
            $languagePresentationModel = $this->serializerWrapper->convertFromToByGroup(
                $language,
                'default',
                LanguagePresentationModel::class
            );

            /** @var Lesson[] $lessons */
            $lessons = $this->lessonRepository->findBy([
                'language' => $language,
            ]);

            foreach ($levels as $level) {
                for ($i = 0; $i < 50; $i++) {
                    /** @var LessonPresentationModel $lessonPresentationModel */
                    $lessonPresentationModel = $this->serializerWrapper->convertFromToByGroup(
                        $lessons[rand(0, count($lessons) - 1)],
                        'default',
                        LessonPresentationModel::class
                    );

                    if (($i % 2) === 0) {
                        $wordModel = $this->presentationModelDataProvider->getCreateWordModelWithLesson(
                            $languagePresentationModel,
                            $categories,
                            $this->presentationModelDataProvider->getImageModel(),
                            null,
                            $level,
                            $lessonPresentationModel
                        );
                    } else {
                        $wordModel = $this->presentationModelDataProvider->getCreateWordModel(
                            $languagePresentationModel,
                            $categories,
                            $this->presentationModelDataProvider->getImageModel(),
                            null,
                            $level
                        );
                    }

                    $this->wordEntryPoint->create($wordModel);

                    $progress->advance();
                }

                $progress->advance();

                gc_collect_cycles();
            }

            $this->em->clear();
            gc_collect_cycles();

            $progress->advance();
        }

        $progress->finish();
    }
}