<?php

namespace App\Symfony\Command;

use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\PresentationLayer\LearningMetadata\EntryPoint\CategoryEntryPoint;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\PresentationLayer\Model\Category as CategoryPresentationModel;

class CreateCategory extends BaseCommand
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var CategoryEntryPoint $categoryEntryPoint
     */
    private $categoryEntryPoint;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param CategoryEntryPoint $categoryEntryPoint
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        CategoryEntryPoint $categoryEntryPoint,
        ModelValidator $modelValidator
    ) {
        $this->categoryEntryPoint = $categoryEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;

        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('app:create-category');
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
            'name' => 'Category name: ',
        ]);

        $progressBar = $this->getDefaultProgressBar();

        $this->output->writeln('');
        $progressBar->start();
        $this->output->writeln('');

        $this->createCategoryFromAnswers($answers);

        $progressBar->finish();
        $this->output->writeln('');

        $this->outputSuccess();
    }
    /**
     * @param array $answers
     */
    private function createCategoryFromAnswers(array $answers): void
    {
        /** @var CategoryPresentationModel $categoryPresentationModel */
        $categoryPresentationModel = $this->serializerWrapper->getDeserializer()->create($answers, CategoryPresentationModel::class);

        $this->modelValidator->tryValidate($categoryPresentationModel);

        if ($this->modelValidator->hasErrors()) {
            $this->outputFail($this->modelValidator->getErrorsString());

            return;
        }

        $this->categoryEntryPoint->create($categoryPresentationModel);
    }
}