<?php

namespace App\DataSourceLayer\Infrastructure\Doctrine;

use App\DataSourceLayer\Infrastructure\DataSourceInterface;
use App\DataSourceLayer\Infrastructure\DataSourceSetupInterface;

class EntityManagerSetup implements DataSourceSetupInterface
{
    /**
     * @return DataSourceInterface
     */
    public static function createDataSource(): DataSourceInterface
    {
        return new DoctrineDataSource();
    }
}