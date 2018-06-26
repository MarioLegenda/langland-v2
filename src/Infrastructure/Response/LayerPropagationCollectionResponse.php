<?php

namespace App\Infrastructure\Response;

use Library\Infrastructure\Notation\ArrayNotationInterface;

interface LayerPropagationCollectionResponse extends ArrayNotationInterface
{
    /**
     * @return iterable|object[]
     */
    public function getPropagationObjects(): iterable;
}