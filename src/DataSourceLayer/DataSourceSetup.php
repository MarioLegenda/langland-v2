<?php

namespace App\DataSourceLayer;

use App\DataSourceLayer\Doctrine\EntityManagerSetup;

class DataSourceSetup
{
    /**
     * @var DataSourceSetup $instance
     */
    private static $instance;
    /**
     * @var DataSourceInterface $dataSource
     */
    private $dataSource;
    /**
     * @return DataSourceSetup
     */
    public static function inst(): DataSourceSetup
    {
        static::$instance = (static::$instance instanceof static) ? static::$instance : new static();

        return static::$instance;
    }
    /**
     * @param string $type
     * @return DataSourceInterface
     */
    public function getDataSource(string $type): DataSourceInterface
    {
        if (!$this->dataSource instanceof DataSourceInterface) {
            $this->dataSource = EntityManagerSetup::createDataSource();
        }

        return $this->dataSource;
    }
}