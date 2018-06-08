<?php

namespace Library\Http\Request;

class RequestData
{
    /**
     * @var array $data
     */
    private $data;
    /**
     * RequestData constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}