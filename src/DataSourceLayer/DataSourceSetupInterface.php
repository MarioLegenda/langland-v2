<?php

namespace App\DataSourceLayer;

interface DataSourceSetupInterface
{
    /**
     * @return DataSourceInterface
     */
    public static function createDataSource(): DataSourceInterface;
}