<?php

namespace Library\Infrastructure\Notation;

interface ArrayNotationInterface
{
    /**
     * @return iterable
     */
    public function toArray(): iterable;
}