<?php

namespace App\Symfony\Command;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LocaleRepository;
use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
use App\PresentationLayer\Model\Image;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Model\Language as PresentationLanguageModel;

class CreateLanguage extends BaseCommand
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LanguageEntryPoint $languageEntryPoint
     */
    private $languageEntryPoint;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * @var LanguageRepository $languageRepository
     */
    private $languageRepository;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LanguageEntryPoint $languageEntryPoint
     * @param LanguageRepository $languageRepository
     * @param LocaleRepository $localeRepository
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LanguageEntryPoint $languageEntryPoint,
        LanguageRepository $languageRepository,
        LocaleRepository $localeRepository,
        ModelValidator $modelValidator
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->languageRepository = $languageRepository;
        $this->localeRepository = $localeRepository;

        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('app:create-language');
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
            'name' => [
                'question' => 'Language name: ',
                'validator' => function($value) {
                    $existingLanguage = $this->languageRepository->findOneBy([
                        'name' => $value,
                    ]);

                    if ($existingLanguage instanceof Language) {
                        $message = sprintf(
                            'Language \'%s\' already exists',
                            $value
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                }
            ],
            'locale' => [
                'question' => 'Locale: ',
                'validator' => function($value) {
                    $existingLocale = $this->localeRepository->findOneBy([
                        'name' => $value,
                    ]);

                    if (!$existingLocale instanceof Locale) {
                        $message = sprintf(
                            'Locale \'%s\' does not exist. Add it with \'php bin/console app:create-locale\' command',
                            $value
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                }
            ],
            'showOnPage' => 'Show on page: ',
            'description' => 'Description: ',
            'image' => 'Image path (local): ',
        ]);

        $progressBar = $this->getDefaultProgressBar();

        $this->output->writeln('');
        $progressBar->start();
        $this->output->writeln('');

        $this->createLanguageFromAnswers($answers);

        $progressBar->finish();
        $this->output->writeln('');

        $this->outputSuccess();
    }
    /**
     * @param array $answers
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLanguageFromAnswers(array $answers): void
    {
        $answers['image'] = new Image(new UploadedFile($answers['image']));

        /** @var PresentationLanguageModel $presentationLanguageModel */
        $presentationLanguageModel = $this->serializerWrapper->deserialize($answers, PresentationLanguageModel::class);
        $presentationLanguageModel->setImage($answers['image']);
        $this->modelValidator->tryValidate($presentationLanguageModel);

        if ($this->modelValidator->hasErrors()) {
            $this->outputFail($this->modelValidator->getErrorsString());

            return;
        }

        $this->languageEntryPoint->create($presentationLanguageModel);
    }
}