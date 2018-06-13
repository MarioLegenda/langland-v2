<?php

namespace App\Symfony\Command;

use App\PresentationLayer\LearningMetadata\EntryPoint\Language;
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
     * @var Language $languageEntryPoint
     */
    private $languageEntryPoint;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param Language $languageEntryPoint
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        Language $languageEntryPoint
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
        $this->serializerWrapper = $serializerWrapper;

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
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $answers = $this->askQuestions([
            'name' => 'Language name: ',
            'showOnPage' => 'Show on page: ',
            'description' => 'Description: ',
            'images' => 'Images: ',
        ]);

        $this->createLanguageFromAnswers($answers);
    }
    /**
     * @param array $answers
     */
    private function createLanguageFromAnswers(array $answers): void
    {
        $answers['images'] = $this->normalizeArrayInput($answers['images'], ',');

        /** @var PresentationLanguageModel $presentationLanguageModel */
        $presentationLanguageModel = $this->serializerWrapper->getDeserializer()->create($answers, PresentationLanguageModel::class);

        /** @var ModelValidator $validator */
        $validator = $this->serializerWrapper->getModelValidator();
        $validator->tryValidate($presentationLanguageModel);

        if ($validator->hasErrors()) {
            $this->outputFail($validator->getErrorsString());

            return;
        }

        $this->languageEntryPoint->create($presentationLanguageModel);

        $this->outputSuccess();
    }
}