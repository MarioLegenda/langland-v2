<?php

namespace App\Infrastructure\Machine\Kernel;

use App\Library\Infrastructure\CollectionInterface;

interface RandomWordGeneratorInterface
{
    /**
     * @param CollectionInterface $excludeList
     * @return CollectionInterface
     */
    public function getWords(CollectionInterface $excludeList): CollectionInterface;
}