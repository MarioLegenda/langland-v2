<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine;

use App\DataSourceLayer\Infrastructure\DataSourceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;

class DoctrineDataSource implements DataSourceInterface
{
    /**
     * @return object|EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function getSource(): object
    {
        $isDevMode = true;

        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/Entity"), $isDevMode);

        $conn = array(
            'driver' => 'pdo_mysql',
            'dbname' => 'langland',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost',
        );

        return EntityManager::create($conn, $config);
    }
}