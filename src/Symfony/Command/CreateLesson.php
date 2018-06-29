<?php

namespace App\Symfony\Command;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LessonRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\Model\Language;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Model\Language as LanguagePresentationModel;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language as LanguageDataSourceModel;
use App\PresentationLayer\Model\Lesson as LessonPresentationModel;

class CreateLesson extends BaseCommand
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LessonEntryPoint $lessonEntryPoint
     */
    private $lessonEntryPoint;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var LessonRepository $lessonRepository
     */
    private $localeRepository;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LessonEntryPoint $lessonEntryPoint
     * @param ModelValidator $modelValidator
     * @param LocaleRepository $localeRepository
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LessonEntryPoint $lessonEntryPoint,
        LanguageRepository $languageRepository,
        LocaleRepository $localeRepository,
        ModelValidator $modelValidator
    ) {
        $this->lessonEntryPoint = $lessonEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->languageRepository = $languageRepository;
        $this->localeRepository = $localeRepository;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:create-lesson');
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

        $answers = $this->askQuestions([
            'name' => 'Lesson name: ',
            'temporaryText' => 'Temporary text: ',
            'locale' => [
                'question' => 'Locale: ',
                'validator' => function($value) {
                    $locale = $this->localeRepository->findOneBy([
                        'name' => $value,
                    ]);

                    if (!$locale instanceof Locale) {
                        $message = sprintf(
                            'Locale \'%s\' not found',
                            $value
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                }
            ],
            'language' => [
                'question' => 'Language name or id: ',
                'validator' => function($value) {
                    if (!is_array($value) and empty($value)) {
                        $message = sprintf(
                            'Language not found with identifier \'%s\'',
                            $value
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                },
                'normalizer' => function($value) {
                    $query = [];
                    if (is_numeric($value)) {
                        $query = [
                            'id' => (int) $value,
                        ];
                    }
                    else if (is_string($value)) {
                        $query = [
                            'name' => $value,
                        ];
                    }

                    /** @var LanguageDataSourceModel $dbLanguage */
                    $dbLanguage = $this->languageRepository->findOneBy($query);

                    if (!$dbLanguage instanceof LanguageDataSourceModel) {
                        return $value;
                    }

                    /** @var LanguagePresentationModel $presentationModelLanguage */
                    $presentationModelLanguage = $this->serializerWrapper
                        ->convertFromToByGroup($dbLanguage, 'default', Language::class);

                    return $presentationModelLanguage->toArray();
                }
            ],
        ]);

        $progressBar = $this->getDefaultProgressBar();

        $this->output->writeln('');
        $progressBar->start();
        $this->output->writeln('');

        $this->createLessonFromAnswers($answers);

        $progressBar->finish();
        $this->output->writeln('');

        $this->outputSuccess();
    }
    /**
     * @param array $answers
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLessonFromAnswers(array $answers)
    {
        /** @var LessonPresentationModel $lessonPresentationModel */
        $lessonPresentationModel = $this->serializerWrapper
            ->deserialize($answers, LessonPresentationModel::class);

        $this->lessonEntryPoint->create($lessonPresentationModel);
    }
}