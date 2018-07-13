<?php

namespace Library\Infrastructure;

interface CollectionInterface extends
    \IteratorAggregate,
    \Countable,
    ServiceFilterInterface,
    GeneratorInterface {}