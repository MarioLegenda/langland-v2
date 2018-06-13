<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\DataSourceLayer\Infrastructure\DataSourceSetup;
use Doctrine\ORM\EntityManagerInterface;

/** @var EntityManagerInterface $em */
$em = DataSourceSetup::inst()
    ->getDataSource('mysql')
    ->getSource();

return ConsoleRunner::createHelperSet($em);