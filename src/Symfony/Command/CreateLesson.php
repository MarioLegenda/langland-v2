<?php

namespace App\Symfony\Command;

use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\LessonEntryPoint;
use App\PresentationLayer\Model\Language;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Model\Language as LanguagePresentationModel;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Language as LanguageDataSourceModel;
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
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LessonEntryPoint $lessonEntryPoint
     * @param ModelValidator $modelValidator
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LessonEntryPoint $lessonEntryPoint,
        LanguageRepository $languageRepository,
        ModelValidator $modelValidator
    ) {
        $this->lessonEntryPoint = $lessonEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->languageRepository = $languageRepository;

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
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $answers = $this->askQuestions([
            'name' => 'Lesson name: ',
            'temporaryText' => 'Temporary text: ',
            'language' => [
                'question' => 'Language name or id: ',
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
     */
    private function createLessonFromAnswers(array $answers)
    {
        /** @var LessonPresentationModel $lessonPresentationModel */
        $lessonPresentationModel = $this->serializerWrapper
            ->deserialize($answers, LessonPresentationModel::class);

        $this->lessonEntryPoint->create($lessonPresentationModel);
    }
}