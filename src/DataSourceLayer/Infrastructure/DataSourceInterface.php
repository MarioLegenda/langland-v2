<?php

namespace App\DataSourceLayer\Infrastructure;

interface DataSourceInterface
{
    /**
     * @return object
     */
    public function getSource(): object;
}