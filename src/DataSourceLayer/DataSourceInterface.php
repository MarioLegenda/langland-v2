<?php

namespace App\DataSourceLayer;

interface DataSourceInterface
{
    /**
     * @return object
     */
    public function getSource(): object;
}