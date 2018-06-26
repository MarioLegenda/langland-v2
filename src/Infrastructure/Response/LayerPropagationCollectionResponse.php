<?php

namespace App\Infrastructure\Response;

use Library\Infrastructure\Notation\ArrayNotationInterface;

interface LayerPropagationCollectionResponse extends ArrayNotationInterface, LayerPropagationResponse
{
    /**
     * @return iterable|object[]
     */
    public function getPropagationObjects(): iterable;
}