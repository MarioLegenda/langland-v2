<?php

namespace App\LogicLayer\Machine\Logic;

use App\DataSourceLayer\LearningMetadata\WordDataSourceService;

class MachineLogic
{
    /**
     * @var WordDataSourceService $wordDataSourceService
     */
    private $wordDataSourceService;
    /**
     * MachineLogic constructor.
     * @param WordDataSourceService $wordDataSourceService
     */
    public function __construct(
        WordDataSourceService $wordDataSourceService
    ) {
        $this->wordDataSourceService = $wordDataSourceService;
    }
}