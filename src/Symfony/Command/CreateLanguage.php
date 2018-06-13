<?php

namespace App\Symfony\Command;

use App\PresentationLayer\LearningMetadata\EntryPoint\LanguageEntryPoint;
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
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LanguageEntryPoint $languageEntryPoint
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LanguageEntryPoint $languageEntryPoint,
        ModelValidator $modelValidator
    ) {
        $this->languageEntryPoint = $languageEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;

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
            'name' => 'LanguageEntryPoint name: ',
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

        $this->modelValidator->tryValidate($presentationLanguageModel);

        if ($this->modelValidator->hasErrors()) {
            $this->outputFail($this->modelValidator->getErrorsString());

            return;
        }

        $this->languageEntryPoint->create($presentationLanguageModel);

        $this->outputSuccess();
    }
}