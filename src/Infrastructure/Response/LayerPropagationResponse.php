<?php

namespace App\Infrastructure\Response;

use Library\Infrastructure\Notation\ArrayNotationInterface;

interface LayerPropagationResponse extends ArrayNotationInterface
{
    /**
     * @return object
     */
    public function getPropagationObject(): object;
}