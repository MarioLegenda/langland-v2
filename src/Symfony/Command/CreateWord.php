<?php

namespace App\Symfony\Command;

use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Entity\Language;
use App\DataSourceLayer\Infrastructure\LearningMetadata\Doctrine\Repository\LanguageRepository;
use App\Infrastructure\Model\CollectionEntity;
use App\Infrastructure\Model\CollectionMetadata;
use App\PresentationLayer\LearningMetadata\EntryPoint\WordEntryPoint;
use App\PresentationLayer\Model\Image;
use App\PresentationLayer\Model\Word\Translation;
use App\PresentationLayer\Model\Word\Word;
use Infrastructure\Model\ActionType;
use Library\Infrastructure\FileUpload\Implementation\UploadedFile;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use Library\Infrastructure\Helper\TypedArray;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Model\Language as LanguagePresentationModel;

class CreateWord extends BaseCommand
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var WordEntryPoint $wordEntryPoint
     */
    private $wordEntryPoint;
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
     * @param WordEntryPoint $wordEntryPoint
     * @param ModelValidator $modelValidator
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        WordEntryPoint $wordEntryPoint,
        ModelValidator $modelValidator,
        LanguageRepository $languageRepository
    ) {
        $this->wordEntryPoint = $wordEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->languageRepository = $languageRepository;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('app:create-word');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Doctrine\ORM\ORMException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $answers = $this->getAnswers();

        $progressBar = $this->getDefaultProgressBar();

        $this->output->writeln('');
        $progressBar->start();
        $this->output->writeln('');

        $this->createWordFromAnswers($answers);

        $progressBar->finish();
        $this->output->writeln('');

        $this->outputSuccess();
    }
    /**
     * @param array $answers
     * @throws \Doctrine\ORM\ORMException
     */
    private function createWordFromAnswers(array $answers): void
    {
        $answers['image'] = new Image(new UploadedFile($answers['image']));

        /** @var Word $wordPresentationModel */
        $wordPresentationModel = $this->serializerWrapper
            ->deserialize($answers, Word::class);

        $wordPresentationModel->setImage($answers['image']);
        $wordPresentationModel->setCategories($answers['categories']);

        $this->wordEntryPoint->create($wordPresentationModel);
    }
    /**
     * @param $value
     * @return LanguagePresentationModel
     */
    private function normalizeLanguage($value): LanguagePresentationModel
    {
        if (is_numeric($value)) {
            $dbLanguage = $this->languageRepository->findOneBy([
                'id' => (int) $value,
            ]);

            if (!$dbLanguage instanceof Language) {
                $message = sprintf(
                    'Could not find language by id %d',
                    $value
                );

                throw new \RuntimeException($message);
            }

            /** @var LanguagePresentationModel $languagePresentationModel */
            $languagePresentationModel = $this->serializerWrapper
                ->convertFromToByGroup($dbLanguage, 'default', LanguagePresentationModel::class);

            return $languagePresentationModel;
        }

        if (is_string($value)) {
            $dbLanguage = $this->languageRepository->findOneBy([
                'id' => $value,
            ]);

            if (!$dbLanguage instanceof Language) {
                $message = sprintf(
                    'Could not find language by name %s',
                    $value
                );

                throw new \RuntimeException($message);
            }

            /** @var LanguagePresentationModel $languagePresentationModel */
            $languagePresentationModel = $this->serializerWrapper
                ->convertFromToByGroup($dbLanguage, 'default', LanguagePresentationModel::class);

            return $languagePresentationModel;
        }

        $message = sprintf(
            'Could not find language by value %s',
            $value
        );

        throw new \RuntimeException($message);
    }
    /**
     * @return array
     */
    private function getAnswers(): array
    {
        return $this->askQuestions([
            'name' => 'Word: ',
            'type' => 'Type of the word: ',
            'language' => [
                'question' => 'Language (\'id\' or \'name\'): ',
                'validator' => function ($value) {
                    if (!is_array($value)) {
                        $message = sprintf(
                            'Language could not be normalized to %s',
                            'array'
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                },
                'normalizer' => function ($value) {
                    /** @var LanguagePresentationModel $languagePresentationModel */
                    $languagePresentationModel = $this->normalizeLanguage($value);

                    return $languagePresentationModel->toArray();
                }
            ],
            'description' => 'Description: ',
            'level' => [
                'question' => 'Level: ',
                'validator' => function ($value) {
                    if (!is_int($value)) {
                        $message = sprintf(
                            'Level has to be an integer'
                        );

                        throw new \RuntimeException($message);
                    }

                    return $value;
                },
                'normalizer' => function ($value) {
                    if (is_numeric($value)) {
                        return (int) $value;
                    }
                },
            ],
            'pluralForm' => 'Plural form: ',
            'categories' => [
                'question' => 'Categories (only a set of ids): ',
                'normalizer' => function ($value) {
                    $categoryIds = explode(',', $value);

                    $collectionEntity = new CollectionEntity();

                    foreach ($categoryIds as $categoryId) {
                        $collectionEntity->addMetadata(
                            new CollectionMetadata(
                                (int) trim($categoryId),
                                ActionType::fromValue('create')
                            )
                        );
                    }

                    return $collectionEntity;
                }
            ],
            'translations' => [
                'question' => 'Translations (# delimited values): ',
                'normalizer' => function ($value) {
                    $singleTranslationSplit = explode('#', $value);
                    $translations = TypedArray::create('integer', Translation::class);

                    foreach ($singleTranslationSplit as $translationString) {
                        if (empty($translationString)) {
                            continue;
                        }

                        $noSpacesTranslationArray = trim($translationString);

                        $fields = explode(',', $noSpacesTranslationArray);

                        $modelBlueprint = [];
                        foreach ($fields as $field) {
                            $brokenField = explode(':', $field);

                            if (count($brokenField) < 2) {
                                $message = sprintf(
                                    'Invalid value given for %s',
                                    $field
                                );

                                throw new \RuntimeException($message);
                            }

                            $modelBlueprint[trim($brokenField[0])] = trim($brokenField[1]);
                        }

                        /** @var Translation $translationPresentationModel */
                        $translationPresentationModel = $this->serializerWrapper
                            ->deserialize($modelBlueprint, Translation::class);

                        $translations[] = $translationPresentationModel;
                    }

                    if ($translations->isEmpty()) {
                        $message = sprintf(
                            'No translations found for values %s',
                            $value
                        );

                        throw new \RuntimeException($message);
                    }

                    return $translations->toArray();
                },
            ],
            'image' => 'Image path: (local): ',
        ]);
    }
}