<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CombinedSeed extends BaseCommand
{
    public function configure()
    {
        $this->setName('app:combined-seed');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->makeEasier($input, $output);

        $this->output->writeln('<info>Resseting the database via doctrine commands</info>');
        $this->wipeOut();
        $this->output->writeln('<info>Database reset finished</info>');

        $this->output->writeln('<info>Running app:seed-language-data</info>');
        exec('/usr/bin/php bin/console app:seed-language-data --env=test');
        $this->output->writeln('<info>Finished app:seed-language-data</info>');
        $this->output->writeln('<info>Running app:seed-word-data</info>');
        exec('/usr/bin/php bin/console app:seed-word-data --env=test');
        $this->output->writeln('<info>Finished app:seed-word-data</info>');
    }

    private function wipeOut()
    {
        exec('/usr/bin/php bin/console do:da:dr --force --env=test');
        exec('/usr/bin/php bin/console do:da:cr --env=test');
        exec('/usr/bin/php bin/console do:sc:up --force --env=test');
    }
}