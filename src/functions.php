<?php

function apply_on_iterable(iterable $iterable, \Closure $callback)
{
    $newResult = [];

    $iterableGenerator = \Library\Util\Util::createGenerator($iterable);
    foreach ($iterableGenerator as $entry) {
        $newResult[] = $callback->__invoke($entry['item']);
    }

    return $newResult;
}