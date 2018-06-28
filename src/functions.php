<?php

function apply_on_iterable(iterable $iterable, \Closure $callback)
{
    $newResult = [];

    foreach ($iterable as $item) {
        $newResult[] = $callback->__invoke($item);
    }

    return $newResult;
}