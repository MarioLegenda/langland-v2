<?php

namespace App\Symfony\Command;

use App\PresentationLayer\Model\Locale;
use Library\Infrastructure\Helper\ModelValidator;
use Library\Infrastructure\Helper\SerializerWrapper;
use App\PresentationLayer\LearningMetadata\EntryPoint\LocaleEntryPoint;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LocaleCreateCommand extends BaseCommand
{
    /**
     * @var SerializerWrapper $serializerWrapper
     */
    private $serializerWrapper;
    /**
     * @var LocaleEntryPoint $localeEntryPoint
     */
    private $localeEntryPoint;
    /**
     * @var ModelValidator $modelValidator
     */
    private $modelValidator;
    /**
     * CreateLanguage constructor.
     * @param SerializerWrapper $serializerWrapper
     * @param LocaleEntryPoint $localeEntryPoint
     * @param ModelValidator $modelValidator
     */
    public function __construct(
        SerializerWrapper $serializerWrapper,
        LocaleEntryPoint $localeEntryPoint,
        ModelValidator $modelValidator
    ) {
        $this->localeEntryPoint = $localeEntryPoint;
        $this->serializerWrapper = $serializerWrapper;
        $this->modelValidator = $modelValidator;

        parent::__construct();
    }

    public function configure(): void
    {
        $this->setName('app:create-locale');
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
            'name' => 'Locale name: ',
        ]);

        $progressBar = $this->getDefaultProgressBar();

        $this->output->writeln('');
        $progressBar->start();
        $this->output->writeln('');

        $this->createLocaleFromAnswers($answers);

        $progressBar->finish();
        $this->output->writeln('');

        $this->outputSuccess();
    }
    /**
     * @param array $answers
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createLocaleFromAnswers(array $answers): void
    {
        /** @var Locale $localePresentationModel */
        $localePresentationModel = $this->serializerWrapper->deserialize(
            $answers,
            Locale::class
        );

        $this->localeEntryPoint->create($localePresentationModel);
    }
}