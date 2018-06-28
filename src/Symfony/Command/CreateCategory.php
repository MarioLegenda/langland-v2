<?php

namespace App\Symfony\Command;

use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Category;
use App\DataSourceLayer\Infrastructure\Doctrine\Entity\Locale;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\CategoryRepository;
use App\DataSourceLayer\Infrastructure\Doctrine\Repository\LocaleRepository;
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
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;
    /**
     * @var LocaleRepository $localeRepository
     */
    private $localeRepository;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param CategoryEntryPoint $categoryEntryPoint
     * @param CategoryRepository $categoryRepository
     * @param ModelValidator $modelValidator
     * @param LocaleRepository $localeRepository
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        CategoryEntryPoint $categoryEntryPoint,
        CategoryRepository $categoryRepository,
        ModelValidator $modelValidator,
        LocaleRepository $localeRepository
    ) {
        $this->categoryEntryPoint = $categoryEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;
        $this->categoryRepository = $categoryRepository;
        $this->localeRepository = $localeRepository;

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
            'name' => [
                'question' => 'Category name: ',
                'validator' => function($value) {
                    $existingCategory = $this->categoryRepository->findOneBy([
                        'name' => $value
                    ]);

                    if ($existingCategory instanceof Category) {
                        $message = sprintf(
                            'Category with name \'%s\'',
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