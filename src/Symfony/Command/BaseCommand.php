<?php

namespace App\Symfony\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class BaseCommand extends Command
{
    /**
     * @var InputInterface $input
     */
    protected $input;
    /**
     * @var OutputInterface $output
     */
    protected $output;
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function makeEasier(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
    }

    public function configure()
    {
        $this->setName('base-command');
    }
    /**
     * @param string $boolean
     * @return bool
     */
    protected function normalizeBoolean(string $boolean)
    {
        if ($boolean === 'true' or $boolean === 'false') {
            return $boolean === 'true';
        }

        return $boolean;
    }
    /**
     * @param string $delimiter
     * @param string $toNormalize
     * @return array
     */
    protected function normalizeArrayInput(string $toNormalize, string $delimiter): array
    {
        return explode($delimiter, $toNormalize);
    }
    /**
     * @param array $fields
     * @return array
     */
    protected function askQuestions(array $fields): array
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        $questions = [];
        $answers = [];

        foreach ($fields as $field => $q) {
            $qName = sprintf('%s', $field);

            $questions[$qName] = new Question($q);
        }

        foreach ($questions as $field => $question) {
            $answers[$field] = $questionHelper->ask($this->input, $this->output, $question);
        }

        return $answers;
    }
    /**
     * @param string $message
     */
    protected function outputSuccess(string $message = 'Command successful')
    {
        $this->output->writeln('');
        $this->output->writeln(sprintf('<bg=green;options=bold>%s</>', $message));
        $this->output->writeln('');
    }
    /**
     * @param string $message
     */
    protected function outputFail(string $message = 'Command failed')
    {
        $this->output->writeln('');
        $this->output->writeln(sprintf('<bg=red;options=bold>%s</>', $message));
        $this->output->writeln('');
    }
}