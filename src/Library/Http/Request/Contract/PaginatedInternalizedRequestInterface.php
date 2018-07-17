<?php

namespace Library\Http\Request\Contract;

interface PaginatedInternalizedRequestInterface extends PaginatedRequestInterface
{
    /**
     * @return string
     */
    public function getLocale(): string;
}