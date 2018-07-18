<?php

namespace App\Tests\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('app:reset-database');
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->wipeOut();
    }

    private function wipeOut()
    {
        exec('/usr/bin/php bin/console do:da:dr --force --env=test');
        exec('/usr/bin/php bin/console do:da:cr --env=test');
        exec('/usr/bin/php bin/console do:sc:up --force --env=test');
    }
}