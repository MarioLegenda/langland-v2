<?php

namespace App\DataSourceLayer\Doctrine;

use App\DataSourceLayer\DataSourceInterface;
use App\DataSourceLayer\DataSourceSetupInterface;

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