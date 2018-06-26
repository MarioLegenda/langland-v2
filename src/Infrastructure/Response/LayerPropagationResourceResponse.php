<?php

namespace App\Infrastructure\Response;

use Library\Infrastructure\Notation\ArrayNotationInterface;

interface LayerPropagationResourceResponse extends ArrayNotationInterface, LayerPropagationResponse
{
    /**
     * @return object
     */
    public function getPropagationObject(): object;
}