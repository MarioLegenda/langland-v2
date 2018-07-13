<?php

namespace App\PresentationLayer\Machine\EntryPoint;

use App\LogicLayer\Machine\Logic\MachineLogic;

class GameEntryPoint
{
    /**
     * @var MachineLogic $machineLogic
     */
    private $machineLogic;
    /**
     * GameEntryPoint constructor.
     * @param MachineLogic $machineLogic
     */
    public function __construct(
        MachineLogic $machineLogic
    ) {
        $this->machineLogic = $machineLogic;
    }

    public function createInitialSetup()
    {

    }
}