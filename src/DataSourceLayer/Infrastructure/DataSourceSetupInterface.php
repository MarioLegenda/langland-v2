<?php

namespace App\DataSourceLayer\Infrastructure;

interface DataSourceSetupInterface
{
    /**
     * @return DataSourceInterface
     */
    public static function createDataSource(): DataSourceInterface;
}