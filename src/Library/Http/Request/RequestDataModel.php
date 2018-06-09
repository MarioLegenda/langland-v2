<?php

namespace Library\Http\Request;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Type;

/**
 * Class RequestDataModel
 * @package Library\Http\Request
 *
 * @ExclusionPolicy("none")
 */
class RequestDataModel
{
    /**
     * @var string $name
     * @Type("string")
     */
    private $name;
    /**
     * @var array $data
     * @Type("array")
     */
    private $data;
    /**
     * @var string $internalType
     * @Type("string")
     */
    private $internalType;
    /**
     * @var string $method
     * @Type("string");
     */
    private $method;
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
    /**
     * @return string
     */
    public function getInternalType(): string
    {
        return $this->internalType;
    }
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}